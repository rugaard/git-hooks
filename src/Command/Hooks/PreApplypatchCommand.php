<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PreApplypatchCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreApplypatchCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-applypatch')
            ->setDescription('Executes "pre-applypatch" commands');
    }
}
