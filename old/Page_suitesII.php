<?php
$overskrift = "SuitesII";
$hovertext = "'SuitesII'";
$pagename = "Region Midt: SuitesII";

include 'defaults.php';
include 'session.php';
include 'header.php';
include 'banner.php';
include 'connect.php';
include 'components.php';



/**
 * @var $con
 */

$sql = "SELECT s.id, s.name, s.description FROM Suite s ORDER BY s.id ASC";
$suite_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);
accordion($suite_list, "Page_suite.php");

echo "<FORM METHOD='LINK' ACTION='Page_suite.php'>";
echo "<INPUT TYPE='submit' VALUE='Opret suite'>";
echo "</FORM>";
echo "<br>";

echo "<FORM METHOD='LINK' ACTION='Page_testCase.php'>";
echo "<INPUT TYPE='submit' VALUE='Opret testcase'>";
echo "</FORM>";
echo "<br>";

include 'footer.php';
?>