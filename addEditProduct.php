<?php

include_once 'connect.php';
include_once 'Views/viewProduct.php';
include_once 'classes/Products.php';
include_once 'components.php';
/**
 * @var $con
 */

$id = 0;
$name = "";

if (isset(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}
if (isset(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}

echo "productID = ". $id . PHP_EOL;
echo "productName = ". $name . PHP_EOL;

if ($name != "") {  //hvis der er et navn skal modulet opdateres
    $product = new Product($id, $con);
    $product->Update($name);
}
