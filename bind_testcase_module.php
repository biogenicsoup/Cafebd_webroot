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
    
    if($originTestcaseId >0)
    {
        $testcase = new TestCase($originTestcaseId, $con);
        $testcase->bindToStep($stepid, $destinationIndex);
    }
    return;
    if($destinationTestcaseId >0)
    {
        $testcase = new TestCase($destinationTestcaseId, $con);
        $testcase->bindToStep($stepid, $destinationIndex);
    }
    return;
}

if($itemId[0] == 'm') //the item is a module
{
    $moduleid = intval(substr($itemId, 2, strlen($itemId)-2));
    if($destinationTestcaseId >0)
    {
        $testcase = new TestCase($destinationTestcaseId, $con);
        $testcase->bindToModule($moduleid);
    }
    return;
}
    
//$itemId not starting with s or m means this is a reorder 

//todo: implement reorder

