<?php

class UnitTests
{
    public static function run(): int
    {
        return self::elaborateUnitTests(self::runUnitTests());
    }

    public static function refreshApp(): void
    {
        exec('docker exec graphite /bin/bash -c "chmod +x ./protected/docker/scripts/refresh-app.sh && ./protected/docker/scripts/refresh-app.sh"');
    }

    public static function runUnitTests()
    {
        self::refreshApp();
        $unitTestsCommand = 'docker exec graphite ./protected/testRunner.php -u -v';
        exec($unitTestsCommand, $output);
        return $output[count($output) - 1];
    }

    public static function elaborateUnitTests(string $result)
    {
        preg_match('/Errors: (\d+)/', $result, $errors);
        return $errors[1] ?? 0;
    }
}