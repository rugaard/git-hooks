<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class UpdateCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class UpdateCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:update')
            ->setDescription('Executes "update" commands');
    }
}
