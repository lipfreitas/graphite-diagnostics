<?php

class UnitTests
{
    public static function run(): array
    {
        return self::elaborateUnitTests(self::runUnitTests());
    }

    public static function runUnitTests()
    {
        $unitTestsCommand = 'docker exec graphite ./protected/testRunner.php -u';
        exec($unitTestsCommand, $output);

        // Return Output last line
        return $output[count($output) - 1];
    }

    // elaborate unit test results
    public static function elaborateUnitTests(string $result)
    {
        // $result = Tests: 2024, Assertions: 4991, Failures: 2, Skipped: 1.

        // get number of tests
        $tests = explode(',', $result)[0];

        // get number of failures
        $failures = explode(',', $result)[2];

        // return indexed array only with number
        return [
            'tests' => explode(':', $tests)[1],
            'failures' => explode(':', $failures)[1]
        ];
    }
}