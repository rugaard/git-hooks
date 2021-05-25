<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class PushToCheckoutCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PushToCheckoutCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:push-to-checkout')
            ->setDescription('Executes "push-to-checkout" commands');
    }
}
