<?php
$overskrift = "TestCases";
$hovertext = "'TestCases'";
$pagename = "Region Midt: TestCases";

include 'defaults.php';
include 'session.php';
include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';


/**
 * @var $con
 */




$sql = "SELECT tc.id, tc.name name, tc.scriptVersion, tc.testRailId, tt.name testType FROM TestCase tc 
        JOIN TestType tt ON tt.id = tc.testType_id";
$testCase_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

echo "<i>Testcases</i><br><br>
      <table >\n
        <tr >
            <td><h2> Navn </h2></td>
            <td><h2> Beskrivelse </h2></td>
            <td><h2> Version </h2></td>
            <td><h2> TestRailID </h2></td>
            <td><h2> TestType </h2></td>";
            

foreach ($testCase_list as $row)
{
    echo "\t<tr>
                <td><b><a href=\"Page_testCase.php?id=" . $row['id'] . "\">" . $row['name'] . "</a></b></td>
                <td><b><a href=\"Page_testCase.php?id=" . $row['id'] . "\">" . $row['description'] . "</a></b></td>
                <td><b><a href=\"Page_testCase.php?id=" . $row['id'] . "\">" . $row['scriptVersion'] . "</a></b></td>
                <td><b><a href=\"Page_testCase.php?id=" . $row['id'] . "\">" . $row['testRailId'] . "</a></b></td>
                <td><b><a href=\"Page_testCase.php?id=" . $row['id'] . "\">" . $row['testType'] . "</a></b></td>
            </tr>\n";
}
echo "</table>";

echo "<FORM METHOD='post' ACTION='suite.php'>";
echo "<INPUT TYPE='submit' VALUE='Opret suite'>";
echo "</FORM>";
echo "<br>";

echo "<FORM METHOD='post' ACTION='Page_testCase.php'>";
echo "<INPUT TYPE='submit' VALUE='Opret testcase'>";
echo "</FORM>";

include 'footer.php';
