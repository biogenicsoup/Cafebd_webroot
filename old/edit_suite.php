<?php

include 'defaults.php';
include 'header.php';
include 'session.php';
include 'connect.php';

$overskrift = "Edit suite";
$hovertext = "'Edit suite'";
$pagename = "Region Midt: Edit Suite";

/**
 * @var $con
 */
if (isset($_POST['name']))
{
    $suitename = $_POST['name'];
}

if (isset($_POST['name']))
{
    $suitename = $_POST['name'];
}

if (isset($_POST['description']))
{
    $suitedescription = $_POST['description'];
}

if ($suitename != "") //hvis der er et navn skal suiten oprettes
{
    //findes navn i forvejen
    $sql = "SELECT * FROM Suite s WHERE s.name = ?";
    $suite_list = prepared_select($con, $sql, [$suitename])->fetch_all(MYSQLI_ASSOC);
    if(count($suite_list) ==0)
    {
        $sql = "INSERT INTO Suite (name, description) VALUES (?,?)";
        $stmt = prepared_query($con, $sql, [$suitename, $suitedescription]);
        $suiteId = $con->insert_id;
        header("Location: suite_testcase.php?id='.$suiteId.'",true, 301);
        exit();
    }
    else
    {
        $message = "navnet " . $suitename . " findes allerede i forvejen";
        echo "<script type='text/javascript'>
                alert('" . $message . "');
                document.getElementById('name').focus();
              </script>";
    }
}

echo "<strong>Her kan du oprette din suite. </strong><br>";

echo "<table width='300' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
    <tr>
        <form name='edit' method='post' action='old/opret_suite.php'>
            <td>
                <table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>
                    <tr>
                        <td width='78'>Navn på Suiten:</td>
                        <td width='294'><input name='name' type='text' id='name' value='" .$suitename."'></td>
                    </tr>
                    <tr>
                        <td>Beskrivelse:</td>
                        <td><textarea name='description' id='description' rows='5' cols='40'>".$suitedescription."</textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td>
                        <td><input type='submit' name='Submit' value='opret'></td>
                    </tr>
                </table>
            </td>
        </form>
    </tr>
</table>";
include 'footer.php';
?>
