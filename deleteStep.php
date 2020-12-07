<?php

include 'connect.php';
include 'classes/Step.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

echo "stepId = ". $id . PHP_EOL;

$step = new Step($id, $con);
$step->delete();


