<?php


$overskrift = "Suite";
$hovertext = "'Suite'";
$pagename = "Region Midt: Suite";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';
include 'components.php';
include 'classes/Module.php';
include 'Views/viewModule.php';


/**
 * @var $con
 */


echo draw_add_module('addEditModule.php', 0, $con);

$sql = "SELECT m.id, m.name, m.description FROM Module m ORDER BY m.name";
$module_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

echo "<div class='row' style='margin-bottom: 30px;'>
      <div class='col-md-12'>
        <div class='full margin_bottom_30'>
          <div class='accordion border_circle'>
            <div class='bs-example' id='modulelist'> ";
accordion($module_list, "dialogTest.php"); // link to self just for test
echo "          </div>
          </div>
        </div>
      </div>
   </div>";


include 'footer.php';