<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Command\Hooks;

use Rugaard\GitHooks\Abstracts\AbstractHookCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class PostUpdateCommand.
 *
 * @package Rugaard\GitHooks\Command\Hooks
 */
class PostUpdateCommand extends AbstractHookCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setName('hook:post-update')
            ->setDescription('Executes "post-update" commands')
            ->addArgument('updated-refs', InputArgument::IS_ARRAY, 'Array of updated refs');
    }
}
