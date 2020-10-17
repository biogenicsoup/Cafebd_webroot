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
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$name = "";
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    echo "<script>alert('name = " . $name . "');</script>";
}
$description = "";
if (isset($_POST['description'])) {
    $description = $_POST['description'];
    echo "<script>alert('description = " . $description . "');</script>";
}

if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
}

if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $suite = new Suite($id, $con);
    $suite->Update($name, $description, $productid);
}

