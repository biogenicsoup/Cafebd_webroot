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

echo "<div ><p>col-0</p></div>   <div class='container'>
        <div class='row'>
            <div class='col-12'><p>col-12</p></div>
            <div class='col-1'><p>col-1</p></div><div class='col-11'><p>col-11</p></div>
            <div class='col-2'><p>col-2</p></div><div class='col-10'><p>col-10</p></div>
            <div class='col-3'><p>col-3</p></div><div class='col-9'><p>col-9</p></div>
            <div class='col-4'><p>col-4</p></div><div class='col-8'><p>col-8</p></div>
            <div class='col-5'><p>col-5</p></div><div class='col-7'><p>col-7</p></div>
            <div class='col-6'><p>col-6</p></div>
            
            
            
            
            
            
        
             <div class='col-1'>
                <div id='productlist'>";
$products = new Products($con);
foreach ($products->get_products() as $product)
{
    echo draw_product_div_as_link($product, "page_suites.php?id=" . $product->get_id());
}
echo "          </div>
            </div>
            <div class='col-11'>
                <p>her er et hus</p>
            </div>
        </div>
      </div>";
echo draw_add_product('addEditProduct.php');
include 'footer.php';