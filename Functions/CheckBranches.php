<?php
use League\CLImate\CLImate;

class CheckBranches
{
    // list branches that are open PRs
    public function list()
    {
        $climate = new CLImate();
        $branches = Git::getBranchesWithOpenPullRequests();
        return $branches;
    }

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
            $branchHealth = new BranchHealth();
            if(! $branchHealth->isMergedBackWithMaster($branch)){
                $climate->yellow('Branch is not merged back with master');
                continue;
            }

            $unitTests = UnitTests::run();

            if ($unitTests > 0) {
                $climate->red('Unit tests failed');
                $climate->red('Skipping branch');
                continue;
            } else {
                $climate->green($branch . ' has passed unit tests');
                $climate->green($unitTests . ' errors found');
            }
            $climate->border();
        }
    }

    public function filter($filter){
        $this->run(Git::getFilterBranches($filter));
    }
}