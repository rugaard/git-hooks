<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Abstracts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractHookCommand.
 *
 * @abstract
 * @package Rugaard\GitHooks\Abstracts
 */
abstract class AbstractHookCommand extends Command
{
    /**
     * Executes the current command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get all registered hook commands.
        $gitHookCommands = $this->getApplication()->all($this->getName());

        foreach ($gitHookCommands as $command) {
            // Execute hook command.
            $result = $command->run($input, $output);

            // If current command fails,
            // then we'll abort and skip the rest.
            if ($result === Command::FAILURE) {
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
