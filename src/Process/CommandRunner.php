<?php

namespace RMiller\PhpSpecRunExtension\Process;

interface CommandRunner
{
    public function runCommand($path, $args);

    public function isSupported();
}
