<?php

$overskrift = "TestCase";
$hovertext = "'TestCase'";
$pagename = "Region Midt: TestCase";

include 'defaults.php';
include 'header.php';
include 'banner.php';
include 'Step.php';
include 'StepData.php';

include 'mustbeloggedin.php';

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
$gdkey = "";
if (isset($_POST['gdkey']))
{
    $gdkey = $_POST['gdkey'];
}

$gdvalue = "";
if (isset($_POST['gdvalue']))
{
    $gdvalue = $_POST['gdvalue'];
}

$stepname = "";
if (isset($_POST['stepname']))
{
    $stepname = $_POST['stepname'];
}

$stepfunction = "";
if (isset($_POST['stepfunction']))
{
    $stepfunction = $_POST['stepfunction'];
}
if (isset($_POST['stepid']))
{
    $stepid = $_POST['stepid'];
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

//create step if stepname and stepfuntion !=  ""
if($stepname != "" && $stepfunction != "")
{
    $newstep = new Step(0, $stepname, $stepfunction, $testCaseId, $con);
}

// create data if gdkey != ""
if($gdkey != "")
{
    $newdata = new StepData(0, $gdkey, $gdvalue, $stepid, $testCaseId, $con);
}


// show editable Suite info
echo "<form name='edit' method='post' action='Page_testCase.php?id=" . $testCaseId ."'>
        <table>
            <tr>
                <td>
                    <table >
                        <tr>
                            <td >Navn på Testcase:</td>
                            <td ><input name='name' type='text' id='name' value='".$testCaseName."'></td>
                        </tr>
                        <tr>
                            <td>Beskrivelse:</td>
                            <td><textarea name='description' id='description' rows='5' cols='40'>".$testCaseDescription."</textarea></td>
                        </tr>
                        <tr>
                            <td>Version:</td>
                            <td><input name='scriptVersion' type='text' id='scriptVersion' value='".$testCaseScriptVersion."'></td>
                        </tr>
                        <tr>
                            <td>TestRailID:</td>
                            <td><input name='testRailId' type='text' id='testRailId' value='".$testCaseTestRailId."'></td>
                        </tr>
                        <tr>
                            <td>TestType:</td>
                            <td><select name='testType_id' >" . $optionsstr . "</select>
                        </tr>        
                    </table>
                </td>
            </tr>
        </table>";


$sql = "SELECT s.id, s.name, s.function FROM step s JOIN testcase_step ts on s.id = ts.Step_id WHERE ts.TestCase_id = ?";
$steplist = prepared_select($con, $sql, [$testCaseId])->fetch_all(MYSQLI_ASSOC);

   echo "<script>
  $(function() {
      var icons = {
         header: 'iconClosed',
         headerSelected: 'iconOpen'
      };
      $( '#jQuery_accordion' )
      //$( '#accordion > div' )
      .accordion({
        collapsible:true,
        active: false,
        header: '> div > h3',
        icons: icons
      })
      .sortable({
        axis: 'y',
        handle: 'h3',
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( 'h3' ).triggerHandler( 'focusout' );
 
          // Refresh accordion to handle new order
          $( this ).accordion( 'refresh' );
        }
      });
  });
  </script>
  
  <div id='jQuery_accordion'>";

   foreach ($steplist as $row)
   {
       echo"    <div class='group'>
                    <h3>" . $row['name'] . "</h3>
                    <div>
                        <p>" . $row['function'] . "</p>
                        <ul>";

       $sql = "SELECT gd.name, gd.value FROM genericdata gd JOIN testcase_step ts on gd.TestCase_Step_TestCase_id = ts.TestCase_id and gd.TestCase_Step_Step_id = ts.Step_id WHERE ts.TestCase_id = ? AND ts.Step_id =?";
       $datalist = prepared_select($con, $sql, [$testCaseId, $row['id']])->fetch_all(MYSQLI_ASSOC);
       foreach ($datalist as $datarow)
       {
           echo "<li>Key = ". $datarow['key'] ."   Value = " . $datarow['value'] . "</li>";
       }
       echo "<li> Key = <input name='gdkey' type='text' id='gdkey'> Value = <input name='gdvalue' type='text' id='gdvalue'> <input type='hidden' id='stepid' name='stepid' value='".$row['id']."'></li>
          </ul>
       </div>
       </div>";
   }
echo "<div class='group'>
                    <h3>Opret nyt step</h3>
                    <div>
                    <p>Navn = <input name='stepname' type='text' id='stepname'> Funktion = <input name='stepfunction' type='text' id='stepfunction'></p>
                    </div>
                </div>";
echo "</div>";

echo "</table><Input type = 'Submit' Value = 'Gem'>
    </form>";

include 'footer.php';
?>
