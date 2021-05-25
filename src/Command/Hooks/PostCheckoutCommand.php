<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PostCheckoutCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostCheckoutCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-checkout')
            ->setDescription('Executes "post-checkout" commands')
            ->addArgument('previous', InputArgument::REQUIRED, 'Ref of previous HEAD')
            ->addArgument('new', InputArgument::REQUIRED, 'Ref of new HEAD')
            ->addArgument('is-branch', InputArgument::REQUIRED, 'Flag that indicates if checkout was a branch or a file');
    }
}
