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




$query = "SELECT s.id, s.name, s.description FROM Suite s ORDER BY s.id ASC";

$result=mysqli_query($con, $query);
if (!$result)
{
	die('SELECT FROM CafeBD failed: ' . mysqli_error($con));
}

echo "<i> Aktive suiter</i> <br><br>";
echo "<table width='80%'>\n";
echo "<tr height='60'> <td width='10%'> </td> 
						   <td> <h2> Navn </h2></td> 
						   <td > <h2 > Beskrivelse </h2></td> 
						   <tr>";

while($row = mysqli_fetch_array($result))
{
	echo "\t<td><b><a href=\"showSuite.php?id=" . $row['id'] . "\">" . $row['name'] . " " . $row['description'] . "</a></b></td>\n";
	echo "</tr>\n";
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
