<?php

class Git
{
    public static function execute(string $command)
    {
        $rootDirectory = env('GRAPHITE_DIR');
        $output = [];
        $command = "cd $rootDirectory && $command";
        exec($command, $output);
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

    // get branches that have open pull requests
    public static function getBranchesWithOpenPullRequests()
    {
        $branchList = self::execute('git branch -r --no-merged master');
        $branchList = array_filter($branchList, function ($branch) {
            $branch = trim($branch, '* ');
            return str_starts_with($branch, 'origin/gw-');
        });
        return $branchList;
    }

    public static function checkout(string $branch)
    {
        return self::execute("git checkout -f $branch");
    }

    public static function getFilterBranches(string $filter)
    {
        $branchList = self::execute('git branch -r --no-merged master');
        // filter branches by name anywhere in the string with regex pattern
        $branchList = array_filter($branchList, function ($branch) use ($filter) {
            $branch = trim($branch, '* ');
            return preg_match("/$filter/", $branch);
        });

        return $branchList;
    }
}