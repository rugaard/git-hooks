<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PreRebaseCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PreRebaseCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:pre-rebase')
            ->setDescription('Executes "pre-rebase" commands')
            ->addArgument('upstream', InputArgument::REQUIRED, 'Upstream of fork')
            ->addArgument('branch', InputArgument::OPTIONAL, 'Branch of rebasing');
    }
}
