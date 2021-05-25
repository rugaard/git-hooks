<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PreMergeCommitCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreMergeCommitCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-merge-commit')
            ->setDescription('Executes "pre-merge-commit" commands');
    }
}
