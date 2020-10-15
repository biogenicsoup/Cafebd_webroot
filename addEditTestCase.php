<?php

include_once 'connect.php';
include_once 'classes/Product.php';
include_once 'Views/viewSuite.php';
include_once 'Views/viewTestCase.php';
include_once 'components.php';


/**
 * @var $con
 */

$id = 0;
if (isset($_POST['id'])) {
    $moduleId = $_POST['id'];
}

$name = "";
$description = "";
$testrailid = 0;
$testtypeid = "";
$productid = 0;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}

if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['testrailid'])) {
    $testrailid = $_POST['testrailid'];
}

if (isset($_POST['testtypeid'])) {
    $testtypeid = $_POST['testtypeid'];
}

if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
}

if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $testcase = new TestCase($id, $con);
    $testcase->Update($name, $description, $testrailid, $testtypeid, $productid);
}

$product = new Product($productid, $con);
echo draw_testcase_accordion($product->get_testcases());

/*$sql = "SELECT m.id, m.name, m.description FROM Module m ORDER BY m.name";
$module_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);
accordion($module_list, "dialogTest.php"); // link to self just for test*/

