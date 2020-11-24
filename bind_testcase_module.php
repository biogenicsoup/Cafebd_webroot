<?php

include 'connect.php';
include 'classes/includeclasses.php';

/**
 * @var $con
 */

$itemId = "";
if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
}

$originTestcaseId = 0;
if (isset($_POST['originTestcaseId'])) {
    $originTestcaseId = $_POST['originTestcaseId'];
}

$originIndex = -1;
if (isset($_POST['originIndex'])) {
    $originIndex = $_POST['originIndex'];
}

$destinationTestcaseId = 0;
if (isset($_POST['destinationTestcaseId'])) {
    $destinationTestcaseId = $_POST['destinationTestcaseId'];
}

$destinationIndex = -1;
if (isset($_POST['destinationIndex'])) {
    $destinationIndex = $_POST['destinationIndex'];
}

echo "itemId = ". $itemId . PHP_EOL;
echo "originTestcaseId = ". $originTestcaseId . PHP_EOL;
echo "originIndex = ". $originIndex . PHP_EOL;
echo "destinationTestcaseId = ". $destinationTestcaseId . PHP_EOL;
echo "destinationIndex = ". $destinationIndex . PHP_EOL;

if($itemId[0] == 's') //the item is a step
{
    
    $stepid = intval(substr($itemId, 2, strlen($itemId)-2));
    echo "stepid = ". $stepid . PHP_EOL;
    $step = new Step($stepid, $con);
    
    if($originTestcaseId >0)
    {
        $step->unBindFromTestcase($originTestcaseId, $originIndex);
    }
    if($destinationTestcaseId >0)
    {
        $step->bindToTestcase($destinationTestcaseId, $destinationIndex);
    }
    return;
}

if($itemId[0] == 'm') //the item is a module
{
    $moduleid = intval(substr($itemId, 2, strlen($itemId)-2));
    echo "moduleid = ". $moduleid . PHP_EOL;
    $module = new Module($moduleid, $con);
    
    if($originTestcaseId >0)
    {
        $module->unBindFromTestcase($originTestcaseId, $originIndex);
    }
    if($destinationTestcaseId >0)
    {
        $module->bindToTestcase($destinationTestcaseId, $destinationIndex);
    }
    return;
}

