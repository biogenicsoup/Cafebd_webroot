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

$destinationModuleId = 0;
if (isset($_POST['destinationModuleId'])) {
    $destinationModuleId = $_POST['destinationModuleId'];
}

if ($stepId > 0 ) { 
    $step = new Step($stepId, $con);
    if($destinationModuleId > 0) {
        echo $step->bindToModule($destinationModuleId);
    }
    if($originModuleId > 0){
        $step->unBindFromModule($originModuleId);
    }
}

