<?php

include 'connect.php';
include 'classes/Step.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
$name = "";
$function = "";
$productid = 0;
$clonefromid = 0;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
$function = filter_input(INPUT_POST, 'function', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
$productid = filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT);
$clonefromid = filter_input(INPUT_POST, 'clonefromid', FILTER_SANITIZE_NUMBER_INT);


echo "stepId = ". $id . PHP_EOL;
echo "stepName = ". $name . PHP_EOL;
echo "stepFunction = ". $function . PHP_EOL;
echo "productId = ". $productid . PHP_EOL;
echo "clonefromid = ". $clonefromid . PHP_EOL;

if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $step = new Step($id, $con);
    $step->Update($name, $function, (int) $productid);
}

if($clonefromid != 0)
{
    $clonefromstep = new Step($clonefromid, $con);
    foreach ($clonefromstep->get_stepData() as $clonefromstepdata) {
        $stepdata = new StepData(0, $con); //create a new stepdata
        $stepdata->update($clonefromstepdata->get_name(), $clonefromstepdata->get_value(), $step->get_id());
    }
}

