<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception\LowCoverageRatioException;
use PhpSpec\ObjectBehavior;
use RuntimeException;

/**
 * @mixin LowCoverageRatioException
 */
class LowCoverageRatioExceptionSpec extends ObjectBehavior
{
    public function it_should_be_a_RuntimeException()
    {
        $this->shouldHaveType(RuntimeException::class);
    }
}
