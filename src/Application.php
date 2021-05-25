<?php

declare(strict_types=1);

namespace Rugaard\GitHooks;

use Composer\Factory;
use Composer\IO\NullIO;
use NunoMaduro\Collision\Provider as CollisionProvider;
use Rugaard\GitHooks\Abstracts\AbstractCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Finder\Finder;

/**
 * Class Application.
 *
 * @package Rugaard\GitHooks
 */
class Application extends ConsoleApplication
{
    /**
     * Configuration array.
     *
     * @var string[]
     */
    protected $config = [];

    /**
     * Path to Composer's vendor folder.
     *
     * @var string
     */
    protected $composerVendorPath;

    /**
     * Composer's repository manager.
     *
     * @var \Composer\Repository\InstalledRepositoryInterface
     */
    protected $composerRepositoryManager;

    /**
     * Application constructor.
     *
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        // Register Collision provider.
        (new CollisionProvider())->register();

        // Parse custom config.
        $configPath = getcwd() . DIRECTORY_SEPARATOR . 'git-hooks.config.json';
        if (file_exists($configPath)) {
            // Decode configuration file.
            $this->config = json_decode((string) file_get_contents($configPath), true);

            // If decoding failed,
            // then we'll revert to an empty array.
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->config = [];
            }
        }

        // Generate composer vendor path
        // and retrieve the local repository manager.
        $this->composerVendorPath = getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR;
        $this->composerRepositoryManager = Factory::create(new NullIO())->getRepositoryManager()->getLocalRepository();

        // Register internal hooks commands.
        $this->registerInternalCommands();

        // Auto-register git-hook commands.
        $this->registerGitHookCommands();
    }

    /**
     * Register internal commands.
     *
     * @returns void
     */
    protected function registerInternalCommands(): void
    {
        // Set path to internal commands.
        $pathToInternalCommands = __DIR__ . '/Command';

        $finder = new Finder();
        $finder->files()->in($pathToInternalCommands)->name('*Command.php');

        foreach ($finder as $file) {
            // Generate full namespace of file.
            $commandName = 'Rugaard\\GitHooks\\Command' . str_replace([$pathToInternalCommands, '.php', '/'], ['', '', '\\'], $file->getPathName());

            // Validate that command namespace exists.
            if (!class_exists($commandName)) {
                continue;
            }

            // Add command to application.
            $this->add(new $commandName());
        }
    }

    /**
     * Auto-register 'git-hook' commands with our application.
     *
     * @returns void
     */
    protected function registerGitHookCommands(): void
    {
        // Array of commands to register.
        $commandsToRegister = [];

        // Loop through installed "git-hook" typed packages
        // and look for commands to register with our application.
        foreach ($this->getGitHookPackages() as $gitHookPackage) {
            // Get path to package in vendor folder.
            $packagePath = $this->composerVendorPath . $gitHookPackage->getName() . DIRECTORY_SEPARATOR;

            foreach ($gitHookPackage->getAutoload() as $autoloadType => $directories) {
                // Currently, we only support the PSR-4 autoloader.
                // Not sure, we'll ever add support for the other ones.
                if (in_array($autoloadType, ['classmap', 'files', 'psr-0'])) {
                    continue;
                }

                // Parse each registered PSR-4 namespace
                // and look for possible commands to register.
                foreach ($directories as $namespace => $directory) {
                    // Make sure we don't have double "//" in our path.
                    $path = str_replace('//', '/', $packagePath . $directory . DIRECTORY_SEPARATOR);

                    // Find all PHP files in path,
                    // which contains suffix of "Command".
                    $finder = new Finder();
                    $finder->files()->in($path)->name('*Command.php');

                    foreach ($finder as $file) {
                        // Generate full namespace of file.
                        $commandName = $namespace . str_replace([$path, '.php', '/'], ['', '', '\\'], $file->getPathName());

                        // Validate that our generated full namespace exists.
                        if (!class_exists($commandName)) {
                            continue;
                        }

                        // If command is disabled by config,
                        // then we won't register it with our application.
                        if (in_array($commandName, (array) ($this->getConfig()['disable'] ?? []))) {
                            continue;
                        }

                        // Make sure the command implements our contract,
                        // otherwise we won't add it with our application.
                        if (!is_subclass_of($commandName, AbstractCommand::class) || !in_array($commandName::hookType(), $this->supportedGitHooks())) {
                            continue;
                        }

                        // Instantiate command and inject application.
                        /* @var $command \Rugaard\GitHooks\Abstracts\AbstractCommand */
                        $command = new $commandName();
                        $command->setConfig($this->getConfig()['parameters'][$commandName] ?? []);

                        // Add command to application.
                        $commandsToRegister[] = $command;
                    }
                }
            }
        }

        // Loop through configuration file and see if
        // we need to register project specific Git hooks.
        foreach ((array) ($this->getConfig()['register'] ?? []) as $commandName) {
            // Validate that the command exists
            // and implements our required contract.
            if (!class_exists($commandName) || !is_subclass_of($commandName, AbstractCommand::class) || !in_array($commandName::hookType(), $this->supportedGitHooks())) {
                continue;
            }

            // Instantiate command.
            $command = new $commandName();
            $command->setConfig($this->getConfig()['parameters'][$commandName] ?? []);

            // Add command to application.
            $commandsToRegister[] = $command;
        }

        // Register commands with application.
        $this->addCommands($commandsToRegister);
    }

    /**
     * Get installed git-hook packages.
     *
     * @return array<int,\Composer\Package\PackageInterface>
     */
    protected function getGitHookPackages(): array
    {
        // Array of found 'git-hook' packages.
        $gitHookPackages = [];

        // Use Composer's local repository manager,
        // to search for installed packages of type 'git-hook'.
        foreach ($this->composerRepositoryManager->search('', 0, 'git-hook') as $installedPackage) {
            $package = $this->composerRepositoryManager->findPackage($installedPackage['name'], '*');
            if ($package === null) {
                continue;
            }

            // Add package to container.
            $gitHookPackages[] = $package;
        }

        return $gitHookPackages;
    }

    /**
     * Get configuration array.
     *
     * @return array[]|string[]
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Git-hook supported by application.
     *
     * @return string[]
     */
    public static function supportedGitHooks(): array
    {
        return [
            'applypatch-msg',
            'commit-msg',
            'fsmonitor-watchman',
            'post-applypatch',
            'post-checkout',
            'post-commit',
            'post-merge',
            'post-receive',
            'post-rewrite',
            'post-update',
            'pre-applypatch',
            'pre-auto-gc',
            'pre-commit',
            'pre-merge-commit',
            'prepare-commit-msg',
            'pre-push',
            'pre-rebase',
            'pre-receive',
            'push-to-checkout',
            'reference-transaction',
            'update',
            'sendemail-validate'
        ];
    }
}
