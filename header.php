<?php
include 'head.php';
include 'connect.php';
include 'session.php';
/**
 * @var $con
 * @var $loggedin
 */

if (isset($_POST['productchange'])) // new product has been selected
{
    $productId = $_POST['productchange'];
    $sql = "UPDATE login SET lastProduct=? WHERE name=? and password=?";
    $affected_rows = prepared_query($con, $sql, [$productId, $_SESSION['myusername'], $_SESSION['mypassword']])->affected_rows;
    $_SESSION['product'] = $productId;
}

echo "
<body id='default_theme' class='autotest'><!--about--> 
<!-- loader -->
<!--<div class='bg_load'> <img class='loader_animation' src='images/loaders/loader_1_inv.png' alt='#' /> </div>-->
<!-- end loader -->
<!-- header -->
    <header id='default_header' class='header_style'>
      <!-- header top -->
      <div class='header_top'>
        <div class='container'>
          <div class='row'>
            <div class='col-md-8'>
              <div class='full'>
                <div class='topbar-left'>
                  <ul class='list-inline'>
                    <li> <span class='topbar-label'><i class='fa fa-home'></i></span> <span class='topbar-hightlight'>Test og Koordinering Oluf Palmes Allé 25 8200 Aarhus N</span> </li>
                    <li> <span class='topbar-label'><i class='fa fa-envelope-o'></i></span> <span class='topbar-hightlight'><a href='mailto:it.test.funktionpostkasse@rm.dk'>it.test.funktionpostkasse@rm.dk</a></span> </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class='col-md-4 right_section_header_top'>
              <div class='float-left'>
                <div class='social_icon'>
                  <ul class='list-inline'>
                    <li><a class='fa fa-facebook' href='https://www.facebook.com/' title='Facebook' target='_blank'></a></li>
                    <li><a class='fa fa-google-plus' href='https://plus.google.com/' title='Google+' target='_blank'></a></li>
                    <li><a class='fa fa-twitter' href='https://twitter.com' title='Twitter' target='_blank'></a></li>
                    <li><a class='fa fa-linkedin' href='https://www.linkedin.com' title='LinkedIn' target='_blank'></a></li>
                    <li><a class='fa fa-instagram' href='https://www.instagram.com' title='Instagram' target='_blank'></a></li>
                  </ul>
                </div>
              </div>
              <div class='float-right'>
                <div class='make_appo'>";

if($loggedin) {
    echo "<a class='btn white_btn' href='logout.php'>logout</a>";
}
else {
    echo "<a class='btn white_btn' href='login.php'>login</a>";
}
 echo"
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end header top -->
  <!-- header bottom -->
  <div class='header_bottom'>
    <div class='container'>
      <div class='row'>
        <div class='col-lg-3 col-md-12 col-sm-12 col-xs-12'>
          <!-- logo start -->
          <div class='logo'> <a href='index.php'><img src='images/logos/Autotest.png' alt='logo' /></a> </div>
          <!-- logo end -->
        </div>
        <div class='col-lg-9 col-md-12 col-sm-12 col-xs-12'>
          <!-- menu start -->
          <div class='menu_side'>
            <div id='navbar_menu'>
              <ul class='first-ul'>
                <li> <a href='index.php'>Home</a>
                  <ul>
                    <li><a href='index.php'>Autotest startside</a></li>
                    <li><a href='http://rm.dk'>Region midtjylland</a></li>
                  </ul>
                </li>
                <li><a class='active' href='the_team.php'>About Us</a></li>
                <li> <a href='services.php'>Service</a>
                  <ul>
                    <li><a href='services.php'>Services list</a></li>
                    <li><a href='engage.php'>Services Detail</a></li>
                  </ul>
                </li>
                <li> <a href='Page_suites.php'>AutotestData</a>
                  <ul>
                    <li><a href='Page_suites.php'>Suites</a></li>
                    <li><a href='testCases.php'>Testcases</a></li>
                  </ul>
                </li>
                <li> <a href='it_contact.html'>Kontakt</a>
                  <ul>
                    <li><a href='it_contact.html'>Contact Page 1</a></li>
                    <li><a href='it_contact_2.html'>Contact Page 2</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class='search_icon'>
              <ul>
                <li><a href='#' data-toggle='modal' data-target='#search_bar'><i class='fa fa-search' aria-hidden='true'></i></a></li>
              </ul>
            </div>
          </div>
          <!-- menu end -->
        </div>
      </div>
    </div>
  </div>
  <!-- header bottom end --> 
    
</header>
<!-- end header -->
";

//todo fix active menu element
function mb_basename($path) {
    if (preg_match('@^.*[\\\\/]([^\\\\/]+)$@s', $path, $matches)) {
        return $matches[1];
    } else if (preg_match('@^([^\\\\/]+)$@s', $path, $matches)) {
        return $matches[1];
    }
    return '';
}

// todo fro active element set <a class='active'> for the selected menuitem
//$("button").click(function(){
//    $("h1, h2, p").addClass("blue");
//    $("div").addClass("important");
//});

