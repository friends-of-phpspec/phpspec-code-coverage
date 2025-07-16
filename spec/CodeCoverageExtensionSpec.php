<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage;

use Exception;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageExtension;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageOptions;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

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
        $container->setParam('code_coverage', ['output' => 'test', 'format' => 'foo']);
        $this->load($container);

        /** @var CodeCoverageOptions $options */
        $options = $container->get('code_coverage.options');

        if (['foo' => 'test'] !== $options->getOutputPaths()) {
            throw new Exception('Default format is not singular output');
        }
    }
}
