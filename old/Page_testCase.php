<?php

$overskrift = "TestCase";
$hovertext = "'TestCase'";
$pagename = "Region Midt: TestCase";

include 'defaults.php';
include 'session.php';
include 'header.php';
include 'banner.php';
include 'connect.php';

/**
 * @var $con
 */
$testCaseId = 0;
if (isset($_POST['id']))
{
    $testCaseId = $_POST['id'];
} else if (isset($_GET['id']))
{
    $testCaseId = $_GET['id'];
}
$testCaseName = "";
$testCaseDescription="";

if (isset($_POST['name']))
{
    $testCaseName = $_POST['name'];
}

if (isset($_POST['description']))
{
    $testCaseDescription = $_POST['description'];
}

if (isset($_POST['scriptVersion']))
{
    $testCaseScriptVersion = $_POST['scriptVersion'];
}

if (isset($_POST['testRailId']))
{
    $testCaseTestRailId = $_POST['testRailId'];
}

$testCaseTestType_id = 1;
if (isset($_POST['testType_id']))
{
    $testCaseTestType_id = $_POST['testType_id'];
}

if ($testCaseName != "") //hvis der er et navn skal testCasen oprettes/opdateres
{
    //findes navn i forvejen
    $sql = "SELECT * FROM TestCase t WHERE t.name=? AND t.id !=?";
    $testCase_list = prepared_select($con, $sql, [$testCaseName, $testCaseId])->fetch_all(MYSQLI_ASSOC);
    if(count($testCase_list) ==0) {
        if ($testCaseId == 0) {
            $sql = "INSERT INTO TestCase (name, description, scriptVersion, testRailId, TestType_id) VALUES (?,?,?,?,?)";
            $stmt = prepared_query($con, $sql, [$testCaseName, $testCaseDescription, $testCaseScriptVersion, $testCaseTestRailId, $testCaseTestType_id]);
            $testCaseId = $con->insert_id;
        }
        else {
            $sql = "UPDATE Suite SET name=?, description=? WHERE id=?";
            $affected_rows = prepared_query($con, $sql, [$testCaseName, $testCaseDescription, $testCaseId])->affected_rows;
        }
    }
    else {
        $message = "Navnet " . $testCaseName . " findes allerede i forvejen";
        echo "<script type='text/javascript'>
                alert('" . $message . "');
                document.getElementById('name').focus();
              </script>";
    }
}

//get testcase info
if($testCaseName == "")
{
    $sql = "SELECT * FROM testcase t WHERE t.id = ?";
    $suitematrix = prepared_select($con, $sql, [$testCaseId])->fetch_all(MYSQLI_ASSOC);
    $testCaseName = $suitematrix[0]['name'];
    $testCaseDescription = $suitematrix[0]['description'];
    $testCaseScriptVersion = $suitematrix[0]['scriptVersion'];
    $testCaseTestRailId = $suitematrix[0]['testRailId'];
    $testCaseTestType_id = $suitematrix[0]['TestType_id'];
}
// testtype option
$sql = "SELECT id, name FROM testtype ORDER BY id";
$typematrix = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);
$optionsstr= "";
foreach($typematrix as $row)
{
    $optionsstr .= "<option value=" . $row["id"];
    if($row["id"] == $testCaseTestType_id)
    {
        $optionsstr .= " selected='selected' ";
    }
    $optionsstr .= ">" . $row["name"]. "</option>";
}

// show editable Suite info
echo "<form name='edit' method='post' action='showTestCase.php?id=" . $testCaseId ."'>
        <table width='300' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
                <td>
                    <table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>
                        <tr>
                            <td width='78'>Navn på Testcase:</td>
                            <td width='294'><input name='name' type='text' id='name' value='".$testCaseName."'></td>
                        </tr>
                        <tr>
                            <td>Beskrivelse:</td>
                            <td><textarea name='description' id='description' rows='5' cols='40'>".$testCaseDescription."</textarea></td>
                        </tr>
                        <tr>
                            <td width='78'>Version:</td>
                            <td width='294'><input name='scriptVersion' type='text' id='scriptVersion' value='".$testCaseScriptVersion."'></td>
                        </tr>
                        <tr>
                            <td width='78'>TestRailID:</td>
                            <td width='294'><input name='testRailId' type='text' id='testRailId' value='".$testCaseTestRailId."'></td>
                        </tr>
                        <tr>
                            <td width='78'>TestType:</td>
                            <td width='294'><select name='testType_id' >" . $optionsstr . "</select>
                        </tr>        
                    </table>
                </td>
            </tr>
        </table>";

//get all suites
$sql = "SELECT s.id, s.name FROM Suite s";
$suite_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

// get testcases already in this suite
$sql = "SELECT Suite_id id FROM TestCase_Suite WHERE TestCase_id=?";
$testcase_suite_list = prepared_select($con, $sql, [(int) $testCaseId])->fetch_all(MYSQLI_ASSOC);

//create list of suite ids (number only)
$suite_id_list = [];
foreach($testcase_suite_list as $row)
{
    array_push($suite_id_list, $row["id"]);
}

// list all testcases wirth selection checkboxes
echo "<strong> Tilknyt suites </strong>(gerne flere kryds): <br>
    <table>
        <tr>
            <td><b>Tilknyttet</b></td>
            <td><b>navn</b></td>
            <td><b>description</b></td>
        </tr>";

$returnstr = "";
foreach($suite_list as $row)
{

    $returnstr .= "<tr><td><input type='checkbox' name='suite_checkbox[]' value='" . $row["id"] . "' ";
    if (in_array($row["id"], $suite_id_list))
    {
        $returnstr .= " checked ";
    }
    $returnstr .= "/></td>
                     <td><a href=\"suite.php?id=" . $row['id'] . "\">" . $row['name'] . "</a></td>
                     <td>" . $row["description"] . "</td>
                 </tr>";
}
echo $returnstr;
echo "</table><Input type = 'Submit' Value = 'Gem'>
    </form>";

include 'footer.php';
?>
