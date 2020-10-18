<?php
$overskrift = "Autotest";
$hovertext = "'Autotest'";
$pagename = "Region Midt: Autotest";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';
include 'Views/viewProduct.php';
include 'classes/Products.php';

/**
 * @var $con
 */

echo "<div><p>hephey!!!!!!</p></div>";
$products = new Products($con);
foreach ($products->get_products() as $product)
{
    var_dump($product);
    echo draw_product_div_with_Suites($product);
}


include 'footer.php';