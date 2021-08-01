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
        $this->beConstructedWith(
            $coverage = new CodeCoverage($this->createDriverStub(5, 5), new Filter()),
            75.0
        );
        $coverage->start('acme-foobar');
        $coverage->stop();

        $this->shouldThrow(LowCoverageRatioException::class)->during('afterSuite', [$event]);
    }

    public function let()
    {
        $this->beConstructedWith(
            $this->coverage = new CodeCoverage($this->createDriverStub(1), new Filter()),
            100
        );
    }

    /**
     * @param mixed $coveredCount
     * @param mixed $uncoveredCount
     */
    private function createDriverStub($coveredCount, $uncoveredCount = 0): Driver
    {
        return new class($coveredCount, $uncoveredCount) extends Driver {
            /**
             * @var int
             */
            private $coveredCount;

            /**
             * @var int
             */
            private $uncoveredCount;

            public function __construct($coveredCount, $uncoveredCount = 0)
            {
                $this->coveredCount = $coveredCount;
                $this->uncoveredCount = $uncoveredCount;
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
                $rawCoverage = [
                    __FILE__ => array_fill(10, $this->coveredCount, 1)
                        + array_fill(10 + $this->coveredCount, $this->uncoveredCount, -1),
                ];

                return RawCodeCoverageData::fromXdebugWithoutPathCoverage($rawCoverage);
            }
        };
    }
}
