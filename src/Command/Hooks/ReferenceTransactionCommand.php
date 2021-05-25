<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ReferenceTransactionCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class ReferenceTransactionCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:reference-transaction')
            ->setDescription('Executes "reference-transaction" commands')
            ->addArgument('state', InputArgument::REQUIRED, 'State of reference transaction');
    }
}
