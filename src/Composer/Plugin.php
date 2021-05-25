<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Rugaard\GitHooks\Application;

/**
 * Class Plugin.
 *
 * @package Rugaard\GitHooks\Composer
 */
class Plugin implements PluginInterface
{
    /**
     * Activate plugin.
     *
     * @param \Composer\Composer       $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->createGitHooks();
    }

    /**
     * Remove any hooks from Composer
     *
     * This will be called when a plugin is deactivated before being
     * uninstalled, but also before it gets upgraded to a new version
     * so the old one can be deactivated and the new one activated.
     *
     * @param \Composer\Composer       $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
        $this->deleteGitHooks();
    }

    /**
     * Prepare the plugin to be uninstalled
     *
     * This will be called after deactivate.
     *
     * @param \Composer\Composer       $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // Do nothing.
    }

    /**
     * Create the git-hook files,
     * that will run our application.
     *
     * @returns void
     */
    public function createGitHooks(): void
    {
        foreach (Application::supportedGitHooks() as $gitHookName) {
            // Generate filename for git-hook.
            $filename = $this->getGitHooksPath() . $gitHookName;

            // Create git-hook script.
            file_put_contents($filename, str_replace('GIT_HOOK_NAME', $gitHookName, file_get_contents(__DIR__  . DIRECTORY_SEPARATOR . '../../stubs/git-hook.stub')));

            // Set permissions of git-hook file.
            chmod($filename, 0755);
        }
    }

    /**
     * Delete the git-hook files,
     * that would run our application.
     *
     * @returns void
     */
    public function deleteGitHooks(): void
    {
        foreach (Application::supportedGitHooks() as $gitHookName) {
            // Generate filename for git-hook.
            $filename = $this->getGitHooksPath() . $gitHookName;

            // Delete git-hook file.
            unlink($filename);
        }
    }

    /**
     * Get path of the git-hooks directory.
     *
     * @return string
     */
    protected function getGitHooksPath(): string
    {
        // Get ".git" path from git itself.
        $gitDir = exec('git rev-parse --git-dir');

        // If ".git" is not part of the retrieved path,
        // we'll append it, so we're sure it's always present.
        if (strpos($gitDir, '.git') === false) {
            $gitDir .= DIRECTORY_SEPARATOR . '.git';
        }

        return $gitDir . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR;
    }
}
