<?php

include 'connect.php';
include 'classes/Step.php';
include 'components.php';
/**
 * @var $con
 */

$id = 0;
if (isset($_POST['id'])) {
    $moduleId = $_POST['id'];
}

$name = "";
$function = "";
$productid = 0;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    echo "<script>alert('name = " . $name . "');</script>";
}

if (isset($_POST['function'])) {
    $description = $_POST['function'];
}

if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
}


if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $step = new Step($id, $con);
    $step->Update($name, $function, $productid);
}

$sql = "SELECT m.id, m.name, m.description FROM Module m ORDER BY m.name";
$module_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);
accordion($module_list, "dialogTest.php"); // link to self just for test
