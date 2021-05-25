<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PreReceiveCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreReceiveCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-receive')
            ->setDescription('Executes "pre-receive" commands');
    }
}
