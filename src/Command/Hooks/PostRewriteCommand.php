<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PostRewriteCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostRewriteCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-rewrite')
            ->setDescription('Executes "post-rewrite" commands')
            ->addArgument('type', InputArgument::REQUIRED, 'Command type that invoked rewrite');
    }
}
