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
if (isset(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
    $name = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}

$name = "";
$description = "";
$testrailid = 0;
$testtypeid = "";
$productid = 0;

if (isset(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}

if (isset(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING))) {
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}

if (isset(filter_input(INPUT_POST, 'testrailid', FILTER_SANITIZE_STRING))) {
    $testrailid = filter_input(INPUT_POST, 'testrailid', FILTER_SANITIZE_STRING);//FILTER_SANITIZE_NUMBER_INT)
}

if (isset(filter_input(INPUT_POST, 'testtypeid', FILTER_SANITIZE_NUMBER_INT))) {
    $testtypeid = filter_input(INPUT_POST, 'testtypeid', FILTER_SANITIZE_NUMBER_INT);
}

if (isset(filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT))) {
    $productid = filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT);
}

echo "testcaseId = ". $id . PHP_EOL;
echo "testcaseName = ". $name . PHP_EOL;
echo "testcaseDescription = ". $description . PHP_EOL;
echo "testrailID = ". $testrailid . PHP_EOL;
echo "testTypeID = ". $testtypeid . PHP_EOL;
echo "productId = ". $productid . PHP_EOL;

if ($name != "" && $productid != 0) { //hvis der er et navn og det er associeret til et produkt skal det oprettet
    $testcase = new TestCase($id, $con);
    $testcase->Update($name, $description, $testrailid, $testtypeid, $productid);
}

/*$product = new Product($productid, $con);
echo draw_testcase_accordion($product->get_testcases());*/



