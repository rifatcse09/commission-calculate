<?php
require_once 'Index.php';

use Application\CommissionTask\Index;

$sourceClass = new Index($argv);
$result = $sourceClass->calculate();

foreach ($result as $r) {
    $sourceClass->showOutput($r);
}