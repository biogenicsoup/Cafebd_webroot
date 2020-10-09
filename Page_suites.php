<?php
$overskrift = "Suites";
$hovertext = "'Suites'";
$pagename = "Region Midt: Suites";

include_once 'defaults.php';
include_once 'header.php';
include_once 'banner.php';
//include 'components.php';
include_once 'mustbeloggedin.php';
include_once 'Views/viewSuite.php';
include_once 'classes/Product.php';

$productid = 0;
if (isset($_POST['id']))
{
    $productid = $_POST['id'];
} else if (isset($_GET['id']))
{
    $productid = $_GET['id'];
}

/**
 * @var $con
 */

$product = new Product($productid, $con);
var_dump($product);
echo "<div class='displaycontent'><div class='column50' id='suitelist' style='background-color: #00bf00'>";
echo draw_suite_accordion($product->get_suites());
echo "</div></div>
<div class='column50' style='background-color: #0f3e68'></div>";

echo draw_add_suite('suitelist','addEditSuite.php', $productid, $con);

include 'footer.php';
?>