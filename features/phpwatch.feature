# features/phpwatch.feature
Feature: phpwatch
    In order to have more productive work environment
    As a programmer
    I need a command line client that allow you to run arbitrary shell commands whenever changes occur in a list of specified files

    Scenario: Run a command when a monitored file was saved
        Given I am in a directory "test"
        And I have a file named "dojo.php"
        And I have a file named "dojoTest.php"
        When I run "~/src/phpwatch/bin/phpwatch"
        Then I should get:
        """
        phpwatch: running...
        """

