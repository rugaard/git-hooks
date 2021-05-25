<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PrepareCommitMsgCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PrepareCommitMsgCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:prepare-commit-msg')
            ->setDescription('Executes "prepare-commit-msg" commands')
            ->addArgument('message', InputArgument::REQUIRED, 'Commit log message')
            ->addArgument('source', InputArgument::OPTIONAL, 'Source of the commit message')
            ->addArgument('sha', InputArgument::OPTIONAL, 'SHA-1 of commit');
    }
}
