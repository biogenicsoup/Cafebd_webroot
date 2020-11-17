<?php

include 'connect.php';
include 'classes/includeclasses.php';

/**
 * @var $con
 */

$testcaseId = 0;
if (isset($_POST['testcaseId'])) {
    $testcaseId = $_POST['testcaseId'];
}

$originSuiteId = 0;
if (isset($_POST['originSuiteIid'])) {
    $originSuiteId = $_POST['originSuiteIid'];
    echo "<script>alert('originSuiteIid = " . $originSuiteId . "');</script>";
}

$destinationSuiteId = 0;
if (isset($_POST['destinationSuiteId'])) {
    $destinationSuiteId = $_POST['destinationSuiteId'];
}

if ($testcaseId > 0 ) { 
    $testcase = new TestCase($testcaseId, $con);
    if($originSuiteId > 0){
        $testcase->unBindFromSuite($originSuiteId);
    }
    if($destinationSuiteId > 0) {
        $testcase->bindToSuite($destinationSuiteId);
    }
}

