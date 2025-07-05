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

class CodeCoverageReports
{
    /**
     * @var array<string, object>
     */
    private $reports;

    /**
     * @param array<string, object> $reports
     */
    public function __construct(array $reports)
    {
        $this->reports = $reports;
    }

    /**
     * @return array<string, object>
     */
    public function getReports(): array
    {
        return $this->reports;
    }

    public function getReport(string $format): ?object
    {
        return $this->reports[$format] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getAvailableFormats(): array
    {
        return array_keys($this->reports);
    }

    public function hasReport(string $format): bool
    {
        return isset($this->reports[$format]);
    }

    public function count(): int
    {
        return count($this->reports);
    }
}
