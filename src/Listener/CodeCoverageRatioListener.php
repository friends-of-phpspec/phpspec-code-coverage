<?php

declare(strict_types=1);

namespace FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception\LowCoverageRatioException;
use PhpSpec\Event\SuiteEvent;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\ProcessedCodeCoverageData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use function count;

final class CodeCoverageRatioListener implements EventSubscriberInterface
{
    /**
     * @var CodeCoverage
     */
    private $coverage;

    /**
     * @var float
     */
    private $minimumCoverage;

    /**
     * CodeCoverageRatioListener constructor.
     *
     * @param float $minimumCoverage
     */
    public function __construct(CodeCoverage $coverage, $minimumCoverage)
    {
        $this->coverage = $coverage;
        $this->minimumCoverage = (float) $minimumCoverage;
    }

    public function afterSuite(SuiteEvent $event): void
    {
        $actualCoverageRatio = $this->simplifyRatio($this->calculateRatio($this->coverage->getData()));

        if ($actualCoverageRatio < $this->minimumCoverage) {
            throw new LowCoverageRatioException(sprintf(
                'Test suites only cover %1.02f%% of the required %1.02f%% minimum coverage',
                $actualCoverageRatio,
                $this->minimumCoverage
            ));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'afterSuite' => ['afterSuite', -1000],
        ];
    }

    /**
     * @return float
     */
    private function calculateRatio(ProcessedCodeCoverageData $coverageData)
    {
        return $this->calculateRatioForEachFiles($coverageData->lineCoverage());
    }

    /**
     * @param array<string, array> $lineCoverage
     * @param float $initialRatio
     *
     * @return float
     */
    private function calculateRatioForEachFiles(array $lineCoverage, $initialRatio = 0.0)
    {
        if ($lines = array_shift($lineCoverage)) {
            $ratio = $this->calculateRatioForEachFiles($lineCoverage, count(array_filter($lines)) / count($lines));
        }

        return $ratio ?? $initialRatio;
    }

    /**
     * @param float $ratio
     *
     * @return float
     */
    private function simplifyRatio($ratio)
    {
        return (ceil($ratio * 10000) / 10000) * 100;
    }
}
