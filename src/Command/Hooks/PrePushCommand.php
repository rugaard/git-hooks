<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PrePushCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PrePushCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-push')
            ->setDescription('Executes "pre-push" commands')
            ->addArgument('remote', InputArgument::REQUIRED, 'Name of remote')
            ->addArgument('url', InputArgument::REQUIRED, 'URL of remote');
    }
}
