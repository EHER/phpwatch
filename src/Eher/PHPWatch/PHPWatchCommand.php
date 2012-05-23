<?php

namespace Eher\PHPWatch;

use ConsoleKit\Command;
use Symfony\Component\Finder\Finder;

class PHPWatchCommand extends Command
{
    public function execute(array $args, array $options = array())
    {
        if (isset($options['help'])) {
            $this->showHelp();
        }

        if (isset($options['version'])) {
            $this->showVersion();
        }

        if (isset($args[0]) && isset($args[1])) {
            $this->watchFiles($args[0], $args[1]);
        }

        $this->showDefaultMessage();
    }

    private function showHelp()
    {
            $this->writeln("Usage: ./phpwatch [options] \"command\" path");
            $this->writeln("");
            $this->writeln("  --help      Show this message");
            $this->writeln("  --version   Show the version");
            exit;
    }

    private function showVersion()
    {
            $this->writeln("New Version!");
            exit;
    }

    private function watchFiles($command, $path)
    {
            $this->writeln("phpwatch: running...");
            $this->writeln("Watching => $path");
            //while(true) {
                if ($this->hasChangesIn($path)) {
                    $this->runCommand($command);
                }
                sleep(1);
            //}
            exit;
    }

    private function hasChangesIn($path)
    {
        return true;
    }

    private function runCommand($command)
    {
                $this->writeln("Running: $command");
                system($command);
    }

    private function showDefaultMessage()
    {
       $this->writeln("Use './phpwatch --help' for more info");
    }
}
