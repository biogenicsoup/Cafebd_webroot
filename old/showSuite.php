<?php
include 'connect.php';
include 'session.php';
include 'header.php';

/**
 * @var $con
 */

$edit = false;



if (isset($_GET['id']))
{
    $suiteId = $_GET['id'];
    $edit = true;


    $suite = prepared_select($con, "SELECT s.name name, s.description description FROM Suite s WHERE s.id = ?", [$suiteId])->fetch_all(MYSQLI_ASSOC);
    //var_dump ($suite);
    //print_r ($suite);
    echo "<h2>Suite: ". $suite[0]['name'] ." </h2>";
    echo "<h4>Description: ". $suite[0]['description'] ." </h4>";
    echo "<h4> Test cases: </h4>";


    $suite_list = prepared_select($con, "SELECT tc.id, tc.name, tc.scriptVersion, tc.testRailId FROM Suite s INNER JOIN TestCase_Suite tcs ON tcs.Suite_id = ? INNER JOIN TestCase tc ON tc.id = tcs.TestCase_id WHERE s.id = ?", [$suiteId, $suiteId])->fetch_all(MYSQLI_ASSOC);

    echo "<table >\n";
    echo "<tr><td><h2> Navn </h2></td><td> <h2> Version </h2></td><td><h2> TestRail ID </h2></td></tr>\n";

    foreach ($suite_list as $row)
    {
        echo "\t<tr><td><a href=\"showTestCase.php?id=" . $row['id'] . "\">" . $row['name'] . "</a></td><td>" . $row['scriptVersion'] . "</td><td>" . $row['testRailId'] . "</td></tr>\n";
    }
    echo "</table>";


}
include 'footer.php';
?>