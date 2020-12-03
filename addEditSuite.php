<?php

include_once 'connect.php';
include_once 'Views/viewSuite.php';
include_once 'classes/Products.php';
include_once 'classes/Suite.php';
include_once 'components.php';
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

echo "suiteId = ". $id . PHP_EOL;
echo "suiteName = ". $name . PHP_EOL;
echo "suiteDescription = ". $description . PHP_EOL;
echo "productId = ". $productid . PHP_EOL;

if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $suite = new Suite($id, $con);
    $suite->Update($name, $description, $productid);
}

