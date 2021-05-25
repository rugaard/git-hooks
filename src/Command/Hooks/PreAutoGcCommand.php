<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PreAutoGcCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreAutoGcCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-auto-gc')
            ->setDescription('Executes "pre-auto-gc" commands');
    }
}
