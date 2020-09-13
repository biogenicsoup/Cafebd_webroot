<?php

include 'defaults.php';
include 'header.php';
include 'session.php';
include 'connect.php';
$overskrift = "Velkommen til CafeBD p&aring; Region Midtjylland";
$hovertext = "'CafeBD'";
$pagename = "Region Midtjylland";

/**
 * @var $con
 */

//----------------- main content -------------------//
echo "<br>";

$sql = "SELECT s.id, s.name, s.description FROM Suite s ORDER BY s.id ASC";

$suite_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);
//$stmt = prepared_query($con, $sql, []);
//$suite_list = $stmt->get_result()->fetch_assoc();

echo "<i> Aktive suiter</i> <br><br>";
echo "<table >\n";
echo "<tr height='60'><td><h2> Navn </h2></td><td><h2> Beskrivelse </h2></td></tr>";

foreach ($suite_list as $row)
{
	//echo "row = " . $row;
	echo "\t<tr><td><b><a href=\"showSuite.php?id=" . $row['id'] . "\">" . $row['name'] . " " . $row['description'] . "</a></b></td></tr>\n";
}
echo "</table>";

echo "<FORM METHOD='LINK' ACTION='opret_person.php'>";
echo "<INPUT TYPE='submit' VALUE='Opret person'>";
echo "</FORM>";
echo "<br>";

echo "<FORM METHOD='LINK' ACTION='search.php'>";
echo "<INPUT TYPE='submit' VALUE='S&oslash;g person'>";
echo "</FORM>";
echo "<br>";

echo "<FORM METHOD='LINK' ACTION='tools.php'>";
echo "<INPUT TYPE='submit' VALUE='Tilf&oslash;j indhold til checkboxe/drop down-menuer'>";
echo "</FORM>";

include 'footer.php';
?>
