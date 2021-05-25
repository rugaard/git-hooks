<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PostCommitCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostCommitCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-commit')
            ->setDescription('Executes "post-commit" commands');
    }
}
