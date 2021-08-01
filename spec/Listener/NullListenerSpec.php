<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener\NullListener;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @mixin NullListener
 */
class NullListenerSpec extends ObjectBehavior
{
    public function it_is_an_event_subscriber()
    {
        $this->shouldHaveType(EventSubscriberInterface::class);
    }

    public function it_should_not_subscribe_to_any_events()
    {
        $this->getSubscribedEvents()->shouldBe([]);
    }
}
