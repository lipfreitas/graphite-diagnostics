<?php

class TestFinder
{
    const TESTS_DIR = 'protected\tests\unit';
    public function list(): array
    {
        $tests = [];
        $path = env('GRAPHITE_DIR'). self::TESTS_DIR;
        $dirfiles = (new Components\DirectoryReader)->listFilesFromPath($path);
        foreach ($dirfiles as $file) {
            if (substr($file, -4) === '.php') {
                $tests[] = substr($file, 0, -4);
            }
        }
        return $tests;
    }
}