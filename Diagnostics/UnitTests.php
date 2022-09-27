<?php

class UnitTests
{
    public static function run(): array
    {
        return self::elaborateUnitTests(self::runUnitTests());
    }

    public static function refreshApp(): void
    {
        @exec('docker exec graphite /bin/bash -c "chmod +x ./protected/docker/scripts/refresh-app.sh && ./protected/docker/scripts/refresh-app.sh"');
    }

    public static function runUnitTests()
    {
        self::refreshApp();
        $unitTestsCommand = 'docker exec graphite ./protected/testRunner.php -u';
        exec($unitTestsCommand, $output);

        // Return Output last line
        return $output[count($output) - 1];
    }

    // elaborate unit test results
    public static function elaborateUnitTests(string $result)
    {
        var_dump($result);
        if (! preg_match('/Tests: \d+, Assertions: \d+, Failures: \d+, Errors: \d+/', $result)) {
            return [];
        }

        // get number of tests from result string using regex
        $tests = preg_match('/Tests: (\d+)/', $result, $matches);

        // get number of failure from result string using regex
        $failures = preg_match('/Failures: \d+/', $result, $failures);

        // return indexed array only with number
        return [
            'tests' => $tests,
            'failures' => $failures
        ];
    }
}