<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class FsmonitorWatchmanCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class FsmonitorWatchmanCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:fsmonitor-watchman')
            ->setDescription('Executes "fsmonitor-watchman" commands')
            ->addArgument('version', InputArgument::REQUIRED, 'Version of fsmonitor-watchman')
            ->addArgument('data', InputArgument::REQUIRED, 'Time elapsed or token (depending on fsmonitor-watchman version)');
    }
}
