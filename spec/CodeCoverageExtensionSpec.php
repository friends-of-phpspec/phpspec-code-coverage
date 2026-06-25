<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage;

use Exception;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageExtension;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageOptions;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageReports;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener\CodeCoverageListener;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use SebastianBergmann\CodeCoverage\Filter;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * @author Henrik Bjornskov
 */
class CodeCoverageExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CodeCoverageExtension::class);
    }

    public function it_should_allow_to_set_show_only_summary_option(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $container->setParam('code_coverage', ['show_only_summary' => true]);
        $this->load($container);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if (true !== $options->showOnlySummary()) {
            throw new Exception('show_only_summary was not set');
        }
    }

    public function it_should_not_use_show_only_summary_option_by_default(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $this->load($container, []);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if (false !== $options->showOnlySummary()) {
            throw new Exception('show_only_summary should be `false` by default');
        }
    }

    public function it_should_transform_format_into_array(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $container->setParam('code_coverage', ['format' => 'html']);
        $this->load($container);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if ($options->getFormats() !== ['html']) {
            throw new Exception('Default format is not transformed to an array');
        }
    }

    public function it_should_use_html_format_by_default(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $this->load($container, []);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if ($options->getFormats() !== ['html']) {
            throw new Exception('Default format is not html');
        }
    }

    public function it_should_use_singular_output(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $container->setParam('code_coverage', ['output' => 'test', 'format' => 'foo']);
        $this->load($container);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if (['foo' => 'test'] !== $options->getOutputPaths()) {
            throw new Exception('Default format is not singular output');
        }
    }

    public function it_should_not_define_coverage_services_when_no_coverage_option_is_set(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(true));

        $this->load($container);

        foreach ([
            'code_coverage.filter',
            'code_coverage',
            'code_coverage.options',
            'code_coverage.reports',
            'event_dispatcher.listeners.code_coverage',
        ] as $serviceId) {
            if ($container->has($serviceId)) {
                throw new Exception(sprintf('Service "%s" should not be defined', $serviceId));
            }
        }
    }

    public function it_should_not_define_coverage_services_when_no_coverage_is_passed_as_a_raw_cli_option(): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', new ArgvInput(['phpspec', 'run', '--no-coverage']));

        $this->load($container);

        foreach ([
            'code_coverage.filter',
            'code_coverage',
            'code_coverage.options',
            'code_coverage.reports',
            'event_dispatcher.listeners.code_coverage',
        ] as $serviceId) {
            if ($container->has($serviceId)) {
                throw new Exception(sprintf('Service "%s" should not be defined', $serviceId));
            }
        }
    }

    public function it_should_not_define_coverage_services_when_console_input_is_not_registered_yet(): void
    {
        $container = new IndexedServiceContainer();
        $originalArgv = $_SERVER['argv'] ?? null;
        $_SERVER['argv'] = ['phpspec', 'run', '--no-coverage'];

        try {
            $this->load($container);
        } finally {
            if (null === $originalArgv) {
                unset($_SERVER['argv']);
            } else {
                $_SERVER['argv'] = $originalArgv;
            }
        }

        foreach ([
            'code_coverage.filter',
            'code_coverage',
            'code_coverage.options',
            'code_coverage.reports',
            'event_dispatcher.listeners.code_coverage',
        ] as $serviceId) {
            if ($container->has($serviceId)) {
                throw new Exception(sprintf('Service "%s" should not be defined', $serviceId));
            }
        }
    }

    public function it_should_resolve_coverage_services_when_coverage_is_enabled(ConsoleIO $io, Driver $driver): void
    {
        $container = new IndexedServiceContainer();
        $container->set('console.input', $this->createInput(false));
        $container->set('console.io', $io->getWrappedObject());
        $this->load($container);

        $coverageResolved = false;
        $reportsResolved = false;

        $container->define('code_coverage', static function () use (&$coverageResolved, $driver) {
            $coverageResolved = true;

            return new CodeCoverage($driver->getWrappedObject(), new Filter());
        });
        $container->define('code_coverage.reports', static function () use (&$reportsResolved) {
            $reportsResolved = true;

            return new CodeCoverageReports([]);
        });

        $listener = $container->get('event_dispatcher.listeners.code_coverage');

        if (!$listener instanceof CodeCoverageListener) {
            throw new Exception('Coverage listener should be created when coverage is enabled');
        }

        if (!$coverageResolved) {
            throw new Exception('Code coverage driver should be resolved');
        }

        if (!$reportsResolved) {
            throw new Exception('Code coverage reports should be resolved');
        }
    }

    private function createInput(bool $noCoverage): ArrayInput
    {
        $parameters = [];
        if ($noCoverage) {
            $parameters['--no-coverage'] = true;
        }

        return new ArrayInput($parameters, new InputDefinition([
            new InputOption('no-coverage', null, InputOption::VALUE_NONE),
        ]));
    }
}
