<?php

include 'connect.php';
include 'classes/Module.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
if (isset($_POST['id'])) {
    $moduleId = $_POST['id'];
}

$name = "";
$description = "";
$productid = 0;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    echo "<script>alert('name = " . $name . "');</script>";
}

if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
}


if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $module = new Module($id, $con);
    $module->Update($name, $description, 0, $productid);
}

