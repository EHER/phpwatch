    Scenario: Run a command when a monitored file was saved
        Given I am in a directory "test
        And I have a file named "dojo.php"
        And I have a file named "dojoTest.php"
        When I run "phpwatch"

