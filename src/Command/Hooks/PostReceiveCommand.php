<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PostReceiveCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostReceiveCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-receive')
            ->setDescription('Executes "post-receive" commands');
    }
}
