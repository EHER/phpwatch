<?php

namespace Eher\PHPWatch;

use ConsoleKit\Command;
use ConsoleKit\Colors;

class PHPWatchCommand extends Command
{
    public function execute(array $args, array $options = array())
    {
        if (isset($options['help'])) {
            $this->writeln("HELLLP!!", Colors::RED);
            $this->writeln("Usage: ./phpwatch [options] \"command\" path");
            exit;
        }

        if (isset($options['version'])) {
            $this->writeln("New Version!");
            exit;
        }

        if (isset($args[0]) && isset($args[1])) {
            $command = $args[0];
            $path = $args[1];

            $this->writeln("phpwatch: running...");
            $this->writeln("Watching => $path");
            //while(1) {
                sleep(1);
                $this->writeln("Running: $command");
                system($command);
            //}
            exit;
        }

        $this->writeln("Use './phpwatch phpwatch --help' for more info");
    }
}
