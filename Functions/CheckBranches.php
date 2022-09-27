<?php
use League\CLImate\CLImate;
class CheckBranches
{
    public function run()
    {
        $climate = new CLImate();
        $unmergedBranches = Git::getUnmergedBranches();

        foreach ($unmergedBranches as $unmergedBranch)
        {
            $climate->out("Checking branch $unmergedBranch");
            Git::checkout($unmergedBranch);
            $unitTests = UnitTests::run();
            $climate->table($unitTests);
        }
    }
}