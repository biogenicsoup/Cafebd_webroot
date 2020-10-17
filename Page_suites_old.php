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
include_once 'Views/viewTestCase.php';

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
echo "<div class='container'>
        <div class='row'>
            <div class='col-7'>
                <div id='suitelist' >";
echo draw_suite_accordion($product->get_suites());
echo "          </div>
                <div>";
                    echo draw_add_suite('addEditSuite.php', $productid, $con);
echo "          </div>
            </div>
            <div class='col-5'>
                <div id='testcaselist'>";
echo draw_testcase_accordion($product->get_testcases());
echo "          </div>
                <div>";
                    echo draw_add_testcase('testcaselist','addEditTestCase.php', $productid, $con);
echo "          </div>
            </div>
        </div>
      </div>";


include 'footer.php';
?>