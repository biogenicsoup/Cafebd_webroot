<?php

include_once 'connect.php';
include_once 'Views/viewProduct.php';
include_once 'classes/Products.php';
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

if ($name != "") {  //hvis der er et navn skal modulet opdateres
    $product = new Product($id, $con);
    $product->Update($name);
}

$products = new Products($con);
foreach ($products->get_products() as $product)
{
    echo draw_product_div_as_link($product, "page_product.php?id=" . $product->get_id());
}

