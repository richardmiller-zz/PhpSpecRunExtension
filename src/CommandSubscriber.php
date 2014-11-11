<?php

namespace RMiller\PhpSpecRunExtension;

use RMiller\PhpSpecRunExtension\Process\RunRunner\CompositeRunRunner;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandSubscriber implements EventSubscriberInterface
{
    private $runRunner;
    private $commands;

    function __construct(CompositeRunRunner $runRunner, array $commands)
    {
        $this->runRunner = $runRunner;
        $this->commands = $commands;
    }

    public static function getSubscribedEvents()
    {
        return [ConsoleEvents::TERMINATE => 'runRunCommand'];
    }

    public function runRunCommand(ConsoleTerminateEvent $event)
    {
        if (in_array($event->getCommand()->getName(), $this->commands)) {
            $this->runRunner->runRunCommand();
        }
    }
}