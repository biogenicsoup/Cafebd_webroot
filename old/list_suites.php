<?php
include 'connect.php';
/**
 * @var $con
 */

$sql = "SELECT s.id, s.name, s.description FROM Suite s ORDER BY s.id ASC";
$suite_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

echo "<i>Suiter</i><br><br>
      <table >\n
        <tr height='60'>
            <td><h2> Navn </h2></td>
            <td><h2> Beskrivelse </h2></td>
        </tr>";

foreach ($suite_list as $row)
{
    echo "\t<tr>
                <td><b><a href=\"showSuite.php?id=" . $row['id'] . "\">" . $row['name'] . "</a></b></td>
                <td><b><a href=\"showSuite.php?id=" . $row['id'] . "\">" . $row['description'] . "</a></b></td>
            </tr>\n";
}
echo "</table>";
?>
