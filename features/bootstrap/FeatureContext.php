<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\PyStringNode;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * @Given /^I have a directory "([^"]*)"$/
     */
    public function iHaveADirectory($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory);
        }
    }

    /**
     * @Given /^I [sh]ave a file named "([^"]*)" in "([^"]*)"$/
     */
    public function iHaveAFileNamedIn($fileName, $directory)
    {
        touch($directory.DIRECTORY_SEPARATOR.$fileName);
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
                "Actual output is:\n".$this->output
            );
        }
    }

    /**
     * @Given /^I wait (\d+) seconds?$/
     */
    public function iWaitSecond($seconds)
    {
        sleep($seconds);
    }
}
