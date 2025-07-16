<?php

/**
 * This file is part of the friends-of-phpspec/phpspec-code-coverage package.
 *
 * @author ek9 <dev@ek9.co>
 * @license MIT
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 */

declare(strict_types=1);

namespace FriendsOfPhpSpec\PhpSpec\CodeCoverage;

class CodeCoverageOptions
{
    /**
     * @var array<string, mixed>
     */
    private $options;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->options[$key] ?? null;
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function getWithDefault(string $key, $default)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * @return array<string>
     */
    public function getFormats(): array
    {
        return $this->options['format'] ?? ['html'];
    }

    /**
     * @return array<string, string>
     */
    public function getOutputPaths(): array
    {
        return $this->options['output'] ?? [];
    }

    /**
     * @return bool
     */
    public function showUncoveredFiles(): bool
    {
        return $this->options['show_uncovered_files'] ?? true;
    }

    /**
     * @return int
     */
    public function getLowerUpperBound(): int
    {
        return $this->options['lower_upper_bound'] ?? 35;
    }

    /**
     * @return int
     */
    public function getHighLowerBound(): int
    {
        return $this->options['high_lower_bound'] ?? 70;
    }

    /**
     * @return bool
     */
    public function showOnlySummary(): bool
    {
        return $this->options['show_only_summary'] ?? false;
    }
}
