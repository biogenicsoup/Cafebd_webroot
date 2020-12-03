<?php

include 'connect.php';
include_once 'classes/includeclasses.php';
/**
 * @var $con
 */

$id = 0;
$name = "";
$value = "";
$stepid = 0;

if (isset(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}
if (isset(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
}
if (isset(filter_input(INPUT_POST, 'value', FILTER_UNSAFE_RAW))) {
    $value = filter_input(INPUT_POST, 'value', FILTER_UNSAFE_RAW);
}
if (isset(filter_input(INPUT_POST, 'stepid', FILTER_SANITIZE_NUMBER_INT))) {
    $stepid = filter_input(INPUT_POST, 'stepid', FILTER_SANITIZE_NUMBER_INT);
}

echo "stepdataId = ". $id . PHP_EOL;
echo "stepId = ". $stepid . PHP_EOL;
echo "name = ". $name . PHP_EOL;
echo "value = ". $value . PHP_EOL;


if ($name != "" && $stepid != 0) { //hvis der er et navn og det er associeret til et step skal det oprettes
    $stepdata = new StepData($id, $con);
    $stepdata->update($name, $value, $stepid);
}

