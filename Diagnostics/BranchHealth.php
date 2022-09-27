<?php

class BranchHealth
{
    public function check($branch)
    {
        return $this->isMergedBackWithMaster($branch);
    }

    public function isMergedBackWithMaster(string $branch): bool
    {
        Git::checkout($branch);
        Git::execute("git pull origin $branch");
        $behindMaster = Git::execute("git rev-list --left-right --count $branch...origin/master");
        $behindMaster = explode("\t", $behindMaster[0])[1];
        return $behindMaster[0] === 0 ?? true;
    }
}