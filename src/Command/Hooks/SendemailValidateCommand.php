<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;

/**
 * Class SendemailValidateCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class SendemailValidateCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:sendemail-validate')
            ->setDescription('Executes "sendemail-validate" commands');
    }
}
