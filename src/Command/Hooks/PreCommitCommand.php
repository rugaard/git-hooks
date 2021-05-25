<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PreCommitCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreCommitCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-commit')
            ->setDescription('Executes "pre-commit" commands');
    }
}
