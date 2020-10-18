<?php
$overskrift = "Products";
$hovertext = "'Products'";
$pagename = "Region Midt: Products";

include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';
include 'Views/viewProduct.php';
include_once 'classes/includeclasses.php';

/**
 * @var $con
 */

echo "<div class='container'>
        <div class='row'>
            <div class='col-12'>   
                <div id='productlist'>";
$products = new Products($con);
foreach ($products->get_products() as $product)
{
    echo draw_product_div_as_link($product, "page_suites.php?productid=" . $product->get_id());
}
echo "          </div>
            </div>
        </div>
      </div>";
echo draw_add_product('addEditProduct.php');
include 'footer.php';