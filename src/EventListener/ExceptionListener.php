<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage());
    }
}