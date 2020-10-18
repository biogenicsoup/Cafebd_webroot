<?php

$stepid = 0;
if (isset($_POST['stepid'])) {
    $stepid = $_POST['stepid'];
}
if (isset($_GET['stepid']))
{
    $stepid = $_GET['stepid'];
}

if ($stepid == 0 )
{
    header("Location: index.php");
    die();
}

$overskrift = "Step";
$hovertext = "'Step'";
$pagename = "Region Midt: Step";

include_once 'header.php';
include_once 'banner.php';
//include 'components.php';
include_once 'mustbeloggedin.php';
include_once 'Views/viewStep.php';
include_once 'Views/viewStepData.php';
include_once 'classes/includeclasses.php';

$step = new Step($stepid, $con);

echo "<div class='container'>
        <div class='row'>
            <div class='col-3'>
            </div>
            <div class='col-6'>";
                echo draw_step_div_with_addData($step);
echo "      </div>
        </div>
      </div>";         
include 'footer.php';
