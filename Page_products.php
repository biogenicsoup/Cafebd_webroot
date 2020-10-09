<?php
$overskrift = "Products";
$hovertext = "'Products'";
$pagename = "Region Midt: Products";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';
include 'Views/viewProduct.php';
include 'classes/Products.php';

/**
 * @var $con
 */


echo "<div id='productlist'>";
$products = new Products($con);
foreach ($products->get_products() as $product)
{
    echo draw_product_div_as_link($product, "page_suites.php?id=" . $product->get_id());
}
echo "</div>";
echo draw_add_product('productlist', 'addEditProduct.php');
include 'footer.php';