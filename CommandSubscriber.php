<?php

namespace RMiller\BehatSpec\Extension\PhpSpecRunExtension;

use PhpSpec\Console\ConsoleIO;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\RunRunner\CompositeRunRunner;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandSubscriber implements EventSubscriberInterface
{
    private $runRunner;
    private $commands;
    private $io;

    function __construct(CompositeRunRunner $runRunner, ConsoleIO $io, array $commands)
    {
        $this->runRunner = $runRunner;
        $this->commands = $commands;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return [ConsoleEvents::TERMINATE => 'runRunCommand'];
    }

    public function runRunCommand(ConsoleTerminateEvent $event)
    {
        if (!in_array($event->getCommand()->getName(), $this->commands)) {
            return;
        }

        $this->io->writeln();
        if ($this->io->askConfirmation('Do you want to run the phpspec run command now? (Y/n)')) {
            $this->io->writeln();
            $this->runRunner->runRunCommand();
        }
    }
}
