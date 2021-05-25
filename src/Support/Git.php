<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Support;

/**
 * Trait Git.
 *
 * @package Rugaard\GitHooks\Support
 */
trait Git
{
    /**
     * Get absolute path of top-level directory in current working tree.
     *
     * @return string|null
     */
    protected function getGitTopLevelDirectory(): ?string
    {
        // Execute command and retrieve output.
        $output = shell_exec('git rev-parse --show-toplevel');

        // If command failed or output is empty,
        // then we'll return null.
        if (empty($output)) {
            return null;
        }

        return rtrim($output, "\n");
    }

    /**
     * Get path of Git directory.
     *
     * @return string|null
     */
    protected function getGitDirectory(): ?string
    {
        // Execute command and retrieve output.
        $output = shell_exec('git rev-parse --git-common-dir');

        // If command failed or output is empty,
        // then we'll return null.
        if (empty($output)) {
            return null;
        }

        return rtrim($output, "\n");
    }

    /**
     * Get all unstaged files.
     *
     * @param  array $arguments
     * @return array
     */
    protected function getGitUnstagedFiles(array $arguments = []): array
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--name-only',
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git diff ' . implode(' ', $arguments));

        // If command failed or output is empty,
        // then we'll return an empty array.
        if (empty($output)) {
            return [];
        }

        return (array) explode("\n", rtrim($output, "\n"));
    }

    /**
     * Get unstaged files by file extension.
     *
     * @param  string $extension
     * @param  array  $arguments
     * @return array
     */
    protected function getGitUnstagedFilesByExtension(string $extension, array $arguments = []): array
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--name-only'
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git diff ' . implode(' ', $arguments) . ' --  "*.' . $extension . '"');

        // If command failed or output is empty,
        // then we'll return an empty array.
        if (empty($output)) {
            return [];
        }

        return explode("\n", rtrim($output, "\n"));
    }

    /**
     * Get all staged files.
     *
     * @param  array $arguments
     * @return array
     */
    protected function getGitStagedFiles(array $arguments = []): array
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--staged', '--name-only'
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git diff ' . implode(' ', $arguments));

        // If command failed or output is empty,
        // then we'll return an empty array.
        if (empty($output)) {
            return [];
        }

        return (array) explode("\n", rtrim($output, "\n"));
    }

    /**
     * Get staged files by file extension.
     *
     * @param  string $extension
     * @param  array  $arguments
     * @return array
     */
    protected function getGitStagedFilesByExtension(string $extension, array $arguments = []): array
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--staged', '--name-only'
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git diff ' . implode(' ', $arguments) . ' --  "*.' . $extension . '"');

        // If command failed or output is empty,
        // then we'll return an empty array.
        if (empty($output)) {
            return [];
        }

        return explode("\n", rtrim($output, "\n"));
    }

    /**
     * Get all branches in repository.
     *
     * @param array $arguments
     * @return array
     */
    protected function getGitBranches(array $arguments = []): array
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--all'
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git branch ' . implode(' ', $arguments));

        // If command failed or output is empty,
        // then we'll return an empty array.
        if (empty($output)) {
            return [];
        }

        // Convert output to an array.
        $output = explode("\n", rtrim($output, "\n"));

        // Parsed branches.
        $branches = [];

        foreach ($output as $branch) {
            if (substr($branch, 0, 8) === 'remotes/') {
                // Parse remote branch name.
                [, $remote, $branchName] = explode('/', rtrim($branch, "\n"));
                $branches['remote'] = [
                    'name' => $branchName,
                    'remote' => $remote
                ];
            } else {
                // Check if branch is current.
                $isCurrentBranch = substr($branch, 0, 2) === '* ';
                $branches['local'] = [
                    'name' => $isCurrentBranch ? substr($branch, 2) : rtrim($branch, "\n"),
                    'is_current' => $isCurrentBranch
                ];
            }
        }

        return $branches;
    }

    /**
     * Get current branch in repository.
     *
     * @param array $arguments
     * @return string|null
     */
    protected function getGitBranchCurrent(array $arguments = []): ?string
    {
        // Merge arguments with defaults.
        $arguments = array_merge($arguments, [
            '--show-current'
        ]);

        // Execute command and retrieve output.
        $output = shell_exec('git branch ' . implode(' ', $arguments));

        // If command failed or output is empty,
        // then we'll return null.
        if (empty($output)) {
            return null;
        }

        return rtrim($output, "\n");
    }
}
