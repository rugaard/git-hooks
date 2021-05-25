<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PostMergeCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostMergeCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-merge')
            ->setDescription('Executes "post-merge" commands')
            ->addArgument('was-squash', InputArgument::REQUIRED, 'Whether or not merge was squashing');
    }
}
