<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ApplypatchMsgCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class ApplypatchMsgCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:applypatch-msg')
            ->setDescription('Executes "applypatch-msg" commands')
            ->addArgument('message', InputArgument::REQUIRED, 'Commit log message');
    }
}
