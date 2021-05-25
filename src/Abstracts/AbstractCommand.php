<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Abstracts;

use Rugaard\GitHooks\Contract\GitHookContract;
use Rugaard\GitHooks\Support\Git;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand.
 *
 * @abstract
 * @package  Rugaard\GitHooks\Abstracts
 */
abstract class AbstractCommand extends Command implements GitHookContract
{
    use Git;

    /**
     * Command configuration.
     *
     * @var string[]
     */
    protected array $config = [];

    /**
     * AbstractCommand constructor.
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);

        // Do not show in list of command.
        $this->setHidden(true);
    }

    /**
     * Sets the name of the command,
     * "namespaced" by the type of git-hook.
     *
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        return parent::setName('hook:' . $this->hookType() . ':' . $name);
    }

    /**
     * Set command parameters.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->config = array_merge($this->getDefaultConfig() ?? [], $config);
        return $this;
    }

    /**
     * Get config.
     *
     * @param string|null $key
     * @return mixed|null
     */
    protected function getConfig(?string $key = null): mixed
    {
        if (empty($key)) {
            return $this->config;
        }

        return $this->config[$key] ?? null;
    }

    /**
     * Get command's default configuration.
     *
     * @return string[]
     */
    abstract protected function getDefaultConfig(): array;
}
