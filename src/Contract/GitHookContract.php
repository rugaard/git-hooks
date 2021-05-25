<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Contract;

/**
 * Interface GitHookContract.
 *
 * @package Rugaard\GitHooks\Contract
 */
interface GitHookContract
{
    /**
     * Type of git-hook command belongs to.
     *
     * @static
     * @return string
     */
    public static function hookType(): string;
}
