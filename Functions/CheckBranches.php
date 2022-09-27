<?php
use League\CLImate\CLImate;
class CheckBranches
{
    public function run(array $branches = [])
    {
        $climate = new CLImate();
        $branchesWithOpenPullRequests = $branches ?: Git::getBranchesWithOpenPullRequests();
        $numberOfBranchesWithOpenPullRequests = count($branchesWithOpenPullRequests);
        $climate->out('Checking unmerged branches ');
        $climate->out('- '.$numberOfBranchesWithOpenPullRequests . ' unmerged branches found');

        foreach ($branchesWithOpenPullRequests as $branch)
        {
            $climate->out("Checking branch $branch");
            Git::checkout($branch);
            $climate->blue('Running unit tests');
            $unitTests = UnitTests::run();

            if (empty($unitTests) || $unitTests['failures'] > 0) {
                $climate->red('Unit tests failed');
                $climate->yellow('Aborting');
            }else{
                $climate->table([$unitTests]);
                $climate->green($branch . ' has passed unit tests');
            }
            $climate->border();
        }
    }

    public function filter($filter){
        $this->run(Git::getFilterBranches($filter));
    }
}