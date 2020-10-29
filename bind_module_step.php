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
if (isset($_POST['originModuleIid'])) {
    $originModuleId = $_POST['originModuleIid'];
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

if ($stepId > 0 ) { 
    $step = new Step($stepId, $con);
    if($destinationModuleId > 0) {
        echo $step->bindToModule($destinationModuleId, $destinationIndex);
    }
    if($originModuleId > 0){
        $step->unBindFromModule($originModuleId, $originIndex);
    }
}

