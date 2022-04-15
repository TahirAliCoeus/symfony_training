<?php

namespace App\EventListener;

use App\Event\UserDeletedEvent;
use App\Event\UserSignedUpEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class UserSignupListener
{
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onUserCreated(UserSignedUpEvent $event)
    {
        $name = $event->getUser()->getName();
        $this->logger->info($name);
    }
    public function onTest(UserDeletedEvent $event)
    {
        $this->logger->info($event->getUser());
    }

}