<?php

namespace Eher\PHPWatch;

use ConsoleKit\Command;
use Symfony\Component\Finder\Finder;

class PHPWatchCommand extends Command
{
    private $extension = "*.*";
    private $once = false;
    private $verbose = false;

    public function execute(array $args, array $options = array())
    {
        $this->proccessOptions($options);

        if (isset($args[0]) && isset($args[1])) {
            $this->watchFiles($args[0], $args[1]);
        }

        $this->showDefaultMessage();
    }

    private function proccessOptions($options)
    {
        if (isset($options['help'])) {
            $this->showHelp();
        }

        if (isset($options['version'])) {
            $this->showVersion();
        }

        if (isset($options['ext'])) {
            if ($options['ext'] === true) {
                $this->writeln("You should pass extension like this:");
                $this->writeln("");
                $this->writeln("  phpwatch --ext=php");
                $this->writeln("");
                exit(1);
            } else {
                $this->extension = "*.".$options['ext'];
            }
        }

        if (isset($options['once'])) {
            $this->once = $options['once'];
        }

        if (isset($options['verbose'])) {
            $this->verbose = true;
        }
    }

    private function showHelp()
    {
        $this->writeln("Usage: phpwatch [options] \"command\" path");
        $this->writeln("");
        $this->writeln("  --ext       Filter files by extension");
        $this->writeln("  --once      Executes the command once");
        $this->writeln("  --verbose   Verbose mode");
        $this->writeln("  --help      Show this message");
        $this->writeln("  --version   Show the version");
        $this->writeln("");
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
        if ($this->verbose) {
            $this->writeln("Watching => $path");
        }
        while (true) {
            if ($this->hasChangesIn($path)) {
                $this->runCommand($command);
                if ($this->once) {
                    exit;
                }
            }
            sleep(1);
        }
    }

    private function hasChangesIn($path)
    {
        $finder = new Finder();

        $iterator = $finder
            ->files()
            ->followLinks()
            ->date('>= now - 1 second')
            ->name($this->extension)
            ->in($path);

        foreach ($iterator as $file) {
            if ($this->verbose) {
                $this->writeln($file->getRelativePathname());
            }

            return true;
        }

        return false;
    }

    private function runCommand($command)
    {
        if ($this->verbose) {
            $this->writeln($command);
        }
        echo shell_exec($command);
    }

    private function showDefaultMessage()
    {
        $this->writeln("Use 'phpwatch --help' for more info");
    }
}
