<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception\ConfigurationException;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener\CodeCoverageListener;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\ObjectBehavior;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use SebastianBergmann\CodeCoverage\Filter;
use stdClass;

/**
 * Disabled due to tests breaking as php-code-coverage marked their classes
 * final and we cannot mock them. The tests should be converted into proper
 * functional (integration) tests instead. This file is left for reference.
 *
 * @see https://github.com/leanphp/phpspec-code-coverage/issues/19
 *
 * @author Henrik Bjornskov
 */
class CodeCoverageListenerSpec extends ObjectBehavior
{
    public function let(ConsoleIO $io, Driver $driver)
    {
        $codeCoverage = new CodeCoverage($driver->getWrappedObject(), new Filter());

        $this->beConstructedWith($io, $codeCoverage, []);
    }

    public function it_can_process_all_directory_filtering_options(SuiteEvent $event)
    {
        $this->setOptions([
            'whitelist' => [
                'src',
                ['directory' => 'src', 'suffix' => 'Spec.php', 'prefix' => 'Get'],
                ['directory' => 'src', 'suffix' => 'Test.php'],
                ['directory' => 'src'],
            ],
            'whitelist_files' => 'path/to/file.php',
            'blacklist' => [
                'src',
                ['directory' => 'src', 'suffix' => 'Spec.php', 'prefix' => 'Get'],
                ['directory' => 'src', 'suffix' => 'Test.php'],
                ['directory' => 'src'],
            ],
            'blacklist_files' => [
                'path/to/file.php',
                'path/to/file2.php',
            ],
        ]);

        $this
            ->shouldNotThrow(ConfigurationException::class)
            ->during('beforeSuite', [$event]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CodeCoverageListener::class);
    }

    public function it_will_ignore_unknown_directory_filtering_options(SuiteEvent $event)
    {
        $this->setOptions([
            'whitelist' => [
                ['directory' => 'test', 'foobar' => 'baz'],
            ],
        ]);

        $this
            ->shouldNotThrow(ConfigurationException::class)
            ->during('beforeSuite', [$event]);
    }

    public function it_will_throw_if_the_directory_filter_option_type_is_not_supported(SuiteEvent $event)
    {
        $this->setOptions([
            'whitelist' => [
                new stdClass(),
            ],
        ]);

        $this
            ->shouldThrow(ConfigurationException::class)
            ->during('beforeSuite', [$event]);
    }

    public function it_will_throw_if_the_directory_parameter_is_missing(SuiteEvent $event)
    {
        $this->setOptions([
            'whitelist' => [
                ['foobar' => 'baz', 'suffix' => 'Spec.php', 'prefix' => 'Get'],
            ],
        ]);

        $this
            ->shouldThrow(ConfigurationException::class)
            ->during('beforeSuite', [$event]);
    }
}
