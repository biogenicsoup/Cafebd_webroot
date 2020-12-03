<?php

include 'connect.php';
include 'classes/Module.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
$name = "";
$description = "";
$productid = 0;

if (isset(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}
if (isset(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}
if (isset(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING))) {
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}
if (isset(filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT))) {
    $productid = filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT);
}

echo "moduleId = ". $id . PHP_EOL;
echo "moduleName = ". $name . PHP_EOL;
echo "moduleDescription = ". $description . PHP_EOL;
echo "productId = ". $productid . PHP_EOL;


if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $module = new Module($id, $con);
    $module->Update($name, $description, 0, $productid);
}

