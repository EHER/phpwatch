<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

define("TEST_DIR", sys_get_temp_dir() . DIRECTORY_SEPARATOR . "phpwatch_54ndb0x" . DIRECTORY_SEPARATOR);

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
    }

    /**
     * @AfterSuite
     */
    public static function cleanTestFolder()
    {
        if (is_dir(TEST_DIR)) {
            self::rmdirRecursive(TEST_DIR);
        }
    }

    /**
     * @Given /^I am in a directory "([^"]*)"$/
     */
    public function iAmInADirectory($dir)
    {
        $realDir = TEST_DIR . $dir;

        if (!file_exists(TEST_DIR)) {
            mkdir(TEST_DIR);
            if (!file_exists($realDir)) {
                mkdir($realDir);
            }
        }
        chdir($realDir);
    }

    /**
     * @Given /^I have a file named "([^"]*)"$/
     */
    public function iHaveAFileNamed($fileName)
    {
        touch($fileName);
    }

    /**
     * @When /^I run "([^"]*)"$/
     */
    public function iRun($command)
    {
       exec($command, $output);
       $this->output = trim(implode("\n", $output));
    }

    /** @Then /^I should get:$/ */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string) $string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }

    /**
     * Removes files and folders recursively at provided path.
     * @param   string  $path
     */
    private static function rmdirRecursive($path) {
        $files = scandir($path);
        array_shift($files);
        array_shift($files);

        foreach ($files as $file) {
            $file = $path . DIRECTORY_SEPARATOR . $file;
            if (is_dir($file)) {
                self::rmdirRecursive($file);
            } else {
                echo($file);
            }
        }

        echo($path);
    }

}
