<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception\LowCoverageRatioException;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener\CodeCoverageRatioListener;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\ObjectBehavior;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\RawCodeCoverageData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @mixin CodeCoverageRatioListener
 */
class CodeCoverageRatioListenerSpec extends ObjectBehavior
{
    /**
     * @var CodeCoverage
     */
    private $coverage;

    public function it_is_an_event_subscriber()
    {
        $this->shouldHaveType(EventSubscriberInterface::class);
    }

    public function it_should_subscribe_to_after_suite_event_with_least_priority()
    {
        $this->getSubscribedEvents()->shouldBe([
            'afterSuite' => ['afterSuite', -1000],
        ]);
    }

    public function it_should_throw_an_error_if_the_minimum_coverage_is_not_met(SuiteEvent $event)
    {
        $rawCoverageArray = $this->createRawCoverageArray('foobar.php', 10, 0)
            + $this->createRawCoverageArray('acme.php', 10, 10);

        $this->beConstructedWith(
            $coverage = new CodeCoverage($this->createDriverStub($rawCoverageArray), new Filter()),
            66.68
        );
        $coverage->start('acme-foobar');
        $coverage->stop();

        $this->shouldThrow(LowCoverageRatioException::class)->during('afterSuite', [$event]);
    }

    public function let()
    {
        $rawCoverageArray = $this->createRawCoverageArray('foobar.php', 10, 0);
        $this->beConstructedWith(
            $this->coverage = new CodeCoverage($this->createDriverStub($rawCoverageArray), new Filter()),
            100
        );
    }

    /**
     * @param array<string, array> $rawCoverageArray
     */
    private function createDriverStub($rawCoverageArray): Driver
    {
        return new class($rawCoverageArray) extends Driver {
            /**
             * @var array<string, array>
             */
            private $rawCoverageArray;

            public function __construct(array $rawCoverageArray)
            {
                $this->rawCoverageArray = $rawCoverageArray;
            }

            public function nameAndVersion(): string
            {
                return 'DriverStub';
            }

            public function start(): void
            {
            }

            public function stop(): RawCodeCoverageData
            {
                return RawCodeCoverageData::fromXdebugWithoutPathCoverage($this->rawCoverageArray);
            }
        };
    }

    /**
     * @param string $file
     * @param int $coveredCount
     * @param int $uncoveredCount
     *
     * @return array<string, array>
     */
    private function createRawCoverageArray($file, $coveredCount, $uncoveredCount): array
    {
        return [
            $file => array_fill(10, $coveredCount, 1)
                + array_fill(10 + $coveredCount, $uncoveredCount, -1),
        ];
    }
}
