<?php

include 'connect.php';
include 'classes/includeclasses.php';

/**
 * @var $con
 */

$stepId = 0;
if (isset($_POST['stepId'])) {
    $stepId = $_POST['stepId'];
}

$originModuleId = 0;
if (isset($_POST['originModuleId'])) {
    $originModuleId = $_POST['originModuleId'];
}

$originIndex = -1;
if (isset($_POST['originIndex'])) {
    $originIndex = $_POST['originIndex'];
}

$destinationModuleId = 0;
if (isset($_POST['destinationModuleId'])) {
    $destinationModuleId = $_POST['destinationModuleId'];
}

$destinationIndex = -1;
if (isset($_POST['destinationIndex'])) {
    $destinationIndex = $_POST['destinationIndex'];
}

echo "stepId = ". $stepId . PHP_EOL;
echo "originModuleId = ". $originModuleId . PHP_EOL;
echo "originIndex = ". $originIndex . PHP_EOL;
echo "destinationModuleId = ". $destinationModuleId . PHP_EOL;
echo "destinationIndex = ". $destinationIndex . PHP_EOL;

if ($stepId > 0 ) { 
    $step = new Step($stepId, $con); // unbind before bind as only one mind between a step and a module is allowed
    if($originModuleId > 0){
        $step->unBindFromModule($originModuleId, $originIndex);
    }
    if($destinationModuleId > 0) {
        echo $step->bindToModule($destinationModuleId, $destinationIndex);
    }
}

