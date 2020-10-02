<?php
$overskrift = "Suites";
$hovertext = "'Suites'";
$pagename = "Region Midt: Suites";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'components.php';
include 'mustbeloggedin.php';


/**
 * @var $con
 * @var $loggedin
 */

if (!$loggedin)
{
    echo "<br>";
    echo "<i> Du er ikke logget ind og kan ikke oprette/redigere autotest data! </i><br>";
    echo "<a href='index.php'>Home</a>";
    exit();
}

$sql = "SELECT s.id, s.name, s.description FROM Suite s ORDER BY s.name";
$suite_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

echo "<div class='row' style='margin-bottom: 30px;'>
          <div class='col-md-12'>
            <div class='full margin_bottom_30'>
              <div class='accordion border_circle'>
                <div class='bs-example'> ";
accordion($suite_list, "Page_suite.php");
echo "          </div>
              </div>
            </div>
          </div>
       </div>";



echo "<a class='btn sqaure_bt' href='Page_suite.php'>Opret suite</a>";
echo "<a class='btn sqaure_bt' href='Page_testCase.php'>Opret testcase</a>";

include 'footer.php';
?>