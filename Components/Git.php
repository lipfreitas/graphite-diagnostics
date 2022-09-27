<?php

class Git
{
    public static function execute(string $command)
    {
        $rootDirectory = env('GRAPHITE_DIR');
        $output = [];
        $return = 0;
        $command = "cd $rootDirectory && $command";
        exec($command, $output, $return);
        return $output;
    }

    public static function getUnmergedBranches()
    {
        $branchList = self::execute('git branch --no-merged master');
        $branchList = array_filter($branchList, function ($branch) {
            $branch = trim($branch, '* ');
            return str_starts_with($branch, 'gw-');
        });
        return $branchList;
    }

    public static function checkout(string $branch)
    {
        return self::execute("git checkout -f $branch");
    }
}