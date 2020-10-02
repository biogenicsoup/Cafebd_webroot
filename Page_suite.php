<?php

$overskrift = "Suite";
$hovertext = "'Suite'";
$pagename = "Region Midt: Suite";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'mustbeloggedin.php';


/**
 * @var $con
 */
$suiteId = 0;
if (isset($_POST['id']))
{
    $suiteId = $_POST['id'];
} else if (isset($_GET['id']))
{
    $suiteId = $_GET['id'];
}
$suitename = "";
$suitedescription="";

if (isset($_POST['name']))
{
    $suitename = $_POST['name'];
}

if (isset($_POST['description']))
{
    $suitedescription = $_POST['description'];
}

if ($suitename != "") //hvis der er et navn skal suiten oprettes/opdateres
{
    //findes navn i forvejen
    $sql = "SELECT * FROM Suite s WHERE s.name=? AND Product_id = ? AND s.id !=?";
    $suite_list = prepared_select($con, $sql, [$suitename, $_SESSION['product'], $suiteId])->fetch_all(MYSQLI_ASSOC);
    if(count($suite_list) ==0) {
        if ($suiteId == 0) {
            $sql = "INSERT INTO Suite (name, description, Product_id) VALUES (?,?)";
            $stmt = prepared_query($con, $sql, [$suitename, $suitedescription, $_SESSION['product']]);
            $suiteId = $con->insert_id;
        }
        else {
            $sql = "UPDATE Suite SET name=?, description=? WHERE id=?";
            $affected_rows = prepared_query($con, $sql, [$suitename, $suitedescription, $suiteId])->affected_rows;
        }
    }
    else {
        $message = "navnet " . $suitename . " findes allerede i forvejen";
        echo "<script type='text/javascript'>
                alert('" . $message . "');
                document.getElementById('name').focus();
              </script>";
    }
}

//update assigned testcases to suite
if (isset($_POST['testcase_checkbox'])) {
    $testcases = $_POST['testcase_checkbox'];
    $deletequery = "DELETE FROM TestCase_Suite WHERE Suite_id=?";
    $stmt = prepared_query($con, $deletequery, [(int)$suiteId]);

    for ($i = 0; $i < count($testcases); $i++) {
        $insertquery = "INSERT INTO TestCase_Suite (Suite_id, TestCase_id) VALUES (?,?)";
        $stmt = prepared_query($con, $insertquery, [(int)$suiteId, (int)$testcases[$i]]);
    }
}

//get suiteinfo
if($suitename == "")
{
    $sql = "SELECT s.name name, s.description description FROM Suite s WHERE s.id = ?";
    $suitematrix = prepared_select($con, $sql, [$suiteId])->fetch_all(MYSQLI_ASSOC);
    $suitename = $suitematrix[0]['name'];
    $suitedescription = $suitematrix[0]['description'];
}


// show editable Suite info
echo "<form name='edit' method='post' action='Page_suite.php?id=" . $suiteId ."'>
        <table width='300' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
                <td>
                    <table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>
                        <tr>
                            <td width='78'>Navn på Suiten:</td>
                            <td width='294'><input class='field_custom' name='name' type='text' id='name' value='".$suitename."'></td>
                        </tr>
                        <tr>
                            <td>Beskrivelse:</td>
                            <td><textarea name='description' class='field_custom' id='description' rows='5' cols='40'>".$suitedescription."</textarea></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>";

//get all testcases
$sql = "SELECT tc.id, tc.name name, tc.scriptVersion, tc.testRailId, tt.name testType FROM TestCase tc 
        JOIN TestType tt ON tt.id = tc.testType_id";
$testCase_list = prepared_select($con, $sql, [])->fetch_all(MYSQLI_ASSOC);

// get testcases already in this suite
$sql = "SELECT testCase_id id FROM TestCase_Suite WHERE suite_id=?";
$testcase_suite_list = prepared_select($con, $sql, [(int) $suiteId])->fetch_all(MYSQLI_ASSOC);

//create list of testcase ids (number only)
$testcase_suite_list_only_int = [];
foreach($testcase_suite_list as $row)
{
    array_push($testcase_suite_list_only_int, $row["id"]);
}

// list all testcases wirth selection checkboxes
echo "<strong> Tilknyt testcases </strong>(gerne flere kryds): <br>
    <table>
        <tr>
            <td><b>Tilknyttet</b></td>
            <td><b>navn</b></td>
            <td><b>type</b></td>
            <td><b>version</b></td>
            <td><b>testRailId</b></td>
        </tr>";

$returnstr = "";
foreach($testCase_list as $row)
{

    $returnstr .= "<tr><td><input type='checkbox' name='testcase_checkbox[]' value='" . $row["id"] . "' ";
    if (in_array($row["id"], $testcase_suite_list_only_int))
    {
        $returnstr .= " checked ";
    }
    $returnstr .= "/></td>
                     <td><b><a href=\"showTestCase.php?id=" . $row['id'] . "\">". $row["name"] . "</a></b></td>
                     <td>" . $row["testType"] . "</td>
                     <td>" . $row["scriptVersion"] . "</td>
                     <td>" . $row["testRailId"] . "</td>
                 </tr>";
}
echo $returnstr;
echo "</table><Input type = 'Submit' Value = 'Gem'>
    </form>";

include 'footer.php';
?>
