<?php
require 'vendor/autoload.php';
require 'Engine/engine.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Loader::folder('Components');
Loader::folder('Diagnostics');
Loader::folder('Functions');

$checkBranches = new CheckBranches();
$branches = $checkBranches->list();
//
//$checkBranches->filter('wide');
//$checkBranches->filter('equivalent');

$branchHealth = new BranchHealth();

// iterate branches and check branch health
foreach ($branches as $branch) {
    $branch = trim($branch, '* ');
    $branch = str_replace('origin/', '', $branch);
    var_dump($branchHealth->check($branch));
}