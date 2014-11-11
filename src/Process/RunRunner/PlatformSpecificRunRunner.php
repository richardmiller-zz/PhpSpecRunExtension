<?php

namespace RMiller\PhpSpecRunExtension\Process\RunRunner;

use RMiller\PhpSpecRunExtension\Process\CachingExecutableFinder;
use RMiller\PhpSpecRunExtension\Process\CommandRunner;
use RMiller\PhpSpecRunExtension\Process\RunRunner;

class PlatformSpecificRunRunner implements RunRunner
{
    const COMMAND_NAME = 'run';

    /**
     * @var string
     */
    private $phpspecPath;

    /**
     * @var CommandRunner
     */
    private $commandRunner;

    /**
     * @var CachingExecutableFinder
     */
    private $executableFinder;

    /**
     * @param CommandRunner $commandRunner
     * @param CachingExecutableFinder $executableFinder
     * @param string $phpspecPath
     */
    public function __construct(
        CommandRunner $commandRunner,
        CachingExecutableFinder $executableFinder,
        $phpspecPath
    ) {
        $this->commandRunner = $commandRunner;
        $this->executableFinder = $executableFinder;
        $this->phpspecPath = $phpspecPath;
    }

    /**
     * @return boolean
     */
    public function isSupported()
    {
        return $this->commandRunner->isSupported();
    }

    public function runRunCommand()
    {
        $this->commandRunner->runCommand(
            $this->executableFinder->getExecutablePath(),
            [$this->phpspecPath, self::COMMAND_NAME]
        );
    }
}
