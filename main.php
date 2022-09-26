<?php
require 'vendor/autoload.php';
require 'Engine/engine.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Loader::folder('Components');

$widgets = (new TestFinder())->list();
var_dump($widgets);
