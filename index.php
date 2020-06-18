<?php
require_once("vendor/autoload.php");

use App\Robot;
use App\FileParser;

if (sizeof($argv) !== 2) {
    die("Usage: php index.php <TestFile>\n");
}

$parserObj = new FileParser($argv[1]);
$commands = $parserObj->parseFileToCommands();
$robot = new Robot();
$robot->setMoveArea(5, 5);

foreach ($commands as $command) {
    $robot->executeCommand($command);
}