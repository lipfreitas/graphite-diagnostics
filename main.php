<?php
require 'vendor/autoload.php';
require 'Engine/engine.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Loader::folder('Components');
Loader::folder('Diagnostics');
Loader::folder('Functions');

$checkBranches = new CheckBranches();
//$checkBranches->run();

$checkBranches->filter('wide');