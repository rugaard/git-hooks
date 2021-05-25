<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command;

use Rugaard\GitHooks\Style\GitHookStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConfigCommand.
 *
 * @package Rugaard\GitHooks\Command
 */
class ConfigCommand extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('config')
            ->setDescription('Creates a custom git hooks config file');
    }

    /**
     * Executes the current command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        // Instantiate Git Hooks Styles.
        $io = new GitHookStyle($input, $output);

        $io->header('Create Git hooks configuration file');

        // Generate path to config file.
        $pathToConfigFile = getcwd() . '/git-hooks.config.json';

        // Validate that a config file doesn't already exists.
        if (file_exists($pathToConfigFile)) {
            $io->block('Config file already exists.', 'ERROR', 'fg=red;options=bold', '');
            return Command::FAILURE;
        }

        // Create config file from stub.
        if (file_put_contents(getcwd() . '/git-hooks.config.json', file_get_contents(__DIR__ . '/../../stubs/config.stub')) === false) {
            $io->block('Could not write config file.', 'ERROR', 'fg=red;options=bold', '');
            return Command::FAILURE;
        }

        // Output successful message.
        $io->block('Done', 'OK', 'fg=green;options=bold', '');

        return Command::SUCCESS;
    }
}
