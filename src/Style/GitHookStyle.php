<?php

declare(strict_types=1);

namespace Rugaard\GitHooks\Style;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Terminal;

/**
 * Class GitHookStyle.
 *
 * @package Rugaard\GitHooks\Style
 */
class GitHookStyle extends SymfonyStyle
{
    /**
     * Output formatted header.
     *
     * @param string $text
     * @param bool $newLine
     */
    public function header(string $text, bool $newLine = true): void
    {
        // Get length of title.
        $length = (int) Helper::removeDecoration($this->getFormatter(), $text);

        // Generate and Output header style.
        $this->writeln([
            sprintf('<fg=white>%s</>', str_repeat('-', (int) max([$length + 10, 40]))),
            sprintf('<fg=white>%s</>', OutputFormatter::escapeTrailingBackslash($text)),
            sprintf('<fg=white>%s</>', str_repeat('-', (int) max([$length + 10, 40]))),
        ]);

        // Add additional new line.
        if ($newLine) {
            $this->newLine();
        }
    }

    /**
     * Formats a table.
     *
     * @param string[] $headers
     * @param array[] $rows
     * @return void
     */
    public function table(array $headers, array $rows): void
    {
        parent::table($headers, $this->tableRowsWrap($headers, $rows));
    }

    /**
     * Formats a boxed table.
     *
     * @param string[] $headers
     * @param array[] $rows
     * @return void
     */
    public function boxedTable(array $headers, array $rows): void
    {
        $style = clone Table::getStyleDefinition('box');
        $style->setCellHeaderFormat('<info>%s</info>');

        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows(
            $this->tableRowsWrap($headers, $rows)
        );
        $table->setStyle($style);

        $table->render();
        $this->newLine();
    }

    /**
     * Wraps table rows.
     *
     * @param string[] $headers
     * @param array[] $rows
     * @return array
     */
    private function tableRowsWrap(array $headers, array $rows): array
    {
        // Determine width of Terminal window.
        $terminalWidth = (new Terminal())->getWidth() - 2;

        $maxHeaderWidth = strlen($headers[0]);
        array_walk($rows, static function ($row) use (&$maxHeaderWidth) {
            if ($row instanceof TableSeparator) {
                return;
            }

            $length = strlen((string) $row[0]);
            if ($length > $maxHeaderWidth) {
                $maxHeaderWidth = $length;
            }
        });

        $rowWrap = static function ($rows) use ($terminalWidth, $maxHeaderWidth): array {
            return array_map(static function ($row) use ($terminalWidth, $maxHeaderWidth) {
                if ($row instanceof TableSeparator) {
                    return $row;
                }

                return array_map(static function ($value) use ($terminalWidth, $maxHeaderWidth) {
                    return ($terminalWidth > $maxHeaderWidth + 5) ? wordwrap((string) $value, $terminalWidth - $maxHeaderWidth - 5, "\n", \true) : $value;
                }, $row);
            }, $rows);
        };

        return $rowWrap($rows);
    }
}
