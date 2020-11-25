<?php

include 'connect.php';
include_once 'classes/includeclasses.php';
/**
 * @var $con
 */

$id = 0;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$name = "";
$value = "";
$stepid = 0;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}

if (isset($_POST['value'])) {
    $value = $_POST['value'];
}

if (isset($_POST['stepid'])) {
    $stepid = $_POST['stepid'];
}

if ($name != "" && $stepid != 0) { //hvis der er et navn og det er associeret til et step skal det oprettes
    $stepdata = new StepData($id, $con);
    $stepdata->update($name, $value, $stepid);
}

echo "stepdataId = ". $id . PHP_EOL;
echo "stepId = ". $stepid . PHP_EOL;
echo "name = ". $name . PHP_EOL;
echo "value = ". $value . PHP_EOL;