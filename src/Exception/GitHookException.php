<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Exception;

use Exception;
use Throwable;

/**
 * Class GitHookException.
 *
 * @package Rugaard\GitHooks\Exception
 */
class GitHookException extends Exception
{
    /**
     * Name of hook type.
     *
     * @var string|null
     */
    protected $hookType;

    /**
     * GitHookException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param string          $hookType
     * @param \Throwable|null $previous
     */
    public function __construct(string $hookType, string $message, int $code = 0, Throwable $previous = null)
    {
        $this->setHookType($hookType);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Set hook type of exception.
     *
     * @param  string $hookType
     * @return $this
     */
    public function setHookType(string $hookType): self
    {
        $this->hookType = $hookType;
        return $this;
    }

    /**
     * Get exceptions hook type.
     *
     * @return string|null
     */
    public function getHookType(): ?string
    {
        return $this->hookType;
    }
}
