# features/phpwatch.feature
Feature: phpwatch
    In order to have more productive work environment
    As a programmer
    I need a command line client that allow you to run arbitrary shell commands
    whenever changes occur in a list of specified files

    Scenario: Run phpwatch command without parameter
        When I run "bin/phpwatch"
        Then I should get:
         """
         Use 'phpwatch --help' for more info
         """

    Scenario: Run phpwatch command with help option
        When I run "bin/phpwatch --help"
        Then I should get:
        """
        Usage: phpwatch [options] "command" path

          --ext       Filter files by extension
          --once      Executes the command once
          --help      Show this message
          --version   Show the version
        """

    Scenario: Run a command when a monitored file was saved
        Given I have a directory "sandbox"
        And I save a file named "file.php" in "sandbox"
        When I run "bin/phpwatch --once 'echo saved' sandbox"
        Then I should get:
        """
        phpwatch: running...
        Watching => sandbox
        Running: echo saved
        saved
        """
