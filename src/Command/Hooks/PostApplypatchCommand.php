<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PostApplypatchCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostApplypatchCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-applypatch')
            ->setDescription('Executes "post-applypatch" commands');
    }
}
