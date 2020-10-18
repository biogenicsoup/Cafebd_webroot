<?php
/**
 * @var $overskrift
 */
include_once 'connect.php';
include_once 'classes/includeclasses.php';

echo"
<!-- inner page banner -->
<div id='inner_banner' class='section inner_banner_section'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='full'>
          <div class='title-holder'>
            <div class='title-holder-cell text-left'>
              <h1 class='page-title'>".$overskrift."</h1>
              <ol class='breadcrumb'>
                <li><a href='index.php'>Home</a></li>";
if($productid != null && $productid > 0)
{ 
    $product = new Product($productid, $con);
    echo       "<li><a href='Page_products.php'>".$product->get_name()."</a></li>";
}
                
echo"           <li class='active'>".$overskrift."</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->";