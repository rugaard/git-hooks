<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command;

use Rugaard\GitHooks\Style\GitHookStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RegisteredCommand.
 *
 * @package Rugaard\GitHooks\Command
 */
class RegisteredCommand extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('registered')
            ->setDescription('List registered git hooks scripts');
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

        // Output header
        $io->header('Registered Git hooks scripts');

        // Get application instance.
        if ($this->getApplication() == null) {
            $io->block('Could noget get application instance.', 'ERROR', '<fg=red;options=bold>', '');
            return Command::FAILURE;
        }

        // Validate that we have registered Git hooks scripts to list.
        if (count($this->getApplication()->supportedGitHooks()) === count($this->getApplication()->all('hook'))) {
            $io->writeln('<fg=yellow>No registered Git hook scripts found.</>');
            return Command::SUCCESS;
        }

        // Loop through all supported Git hooks,
        // and look for registered scripts for that hook.
        foreach ($this->getApplication()->supportedGitHooks() as $gitHook) {
            // Get registered commands for git hook.
            $hookCommands = $this->getApplication()->all('hook:' . $gitHook);
            if (empty($hookCommands)) {
                continue;
            }

            // Array of table rows.
            $rows = [];

            // Loop through registered commands,
            // and generate a table row with info about it.
            foreach ($hookCommands as $hookCommand) {
                $rows[] = [get_class($hookCommand), $hookCommand->getDescription()];
            }

            $io->writeln(' <fg=cyan;options=bold>' . $gitHook . '</>');
            $io->table(['Namespace', 'Description'], $rows);
        }

        return Command::SUCCESS;
    }
}
