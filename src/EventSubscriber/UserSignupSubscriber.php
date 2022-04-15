<?php

namespace App\EventSubscriber;

use App\Event\UserDeletedEvent;
use App\Event\UserSignedUpEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSignupSubscriber implements EventSubscriberInterface
{
    private  $logger;

    public function __construct( LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public static function getSubscribedEvents()
    {
        return [
            UserSignedUpEvent::NAME => [
                ['logInfo'],
            ],
            UserDeletedEvent::NAME => [
                ['performCleanup']
            ]
        ];
    }
    public function logInfo(UserSignedUpEvent $event)
    {
        $this->logger->info($event->getUser()->getEmail());
    }

    public function performCleanup(UserDeletedEvent $event)
    {
        $this->logger->info($event->getUser());
    }
}