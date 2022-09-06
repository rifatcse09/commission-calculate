<?php
require_once 'Index.php';

use Application\CommissionTask\Index;

$mainClass = new Index($argv);
$result = $mainClass->calculate();

foreach ($result as $r) {
    $mainClass->printOutput($r);
}