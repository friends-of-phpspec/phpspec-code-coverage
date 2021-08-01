<?php

declare(strict_types=1);

namespace FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NullListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [];
    }
}
