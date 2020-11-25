<?php

include 'connect.php';
include 'classes/Step.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$name = "";
$function = "";
$productid = 0;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}

if (isset($_POST['function'])) {
    $description = $_POST['function'];
}

if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
}


if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $step = new Step($id, $con);
    $step->Update($name, $function, (int) $productid);
}

