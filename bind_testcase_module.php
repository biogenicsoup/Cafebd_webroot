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

$destinationTestcaseId = 0;
if (isset($_POST['destinationTestcaseId'])) {
    $destinationTestcaseId = $_POST['destinationTestcaseId'];
}

if($itemId[0] == 's') //the item is a step
{
    $stepid = intval(substr($itemId, 2, strlen($itemId)-2));
    if($destinationTestcaseId >0)
    {
        $testcase = new TestCase($destinationTestcaseId, $con);
        $testcase->bindToStep($stepid);
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

