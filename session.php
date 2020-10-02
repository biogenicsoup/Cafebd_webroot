<?php
session_start();


if (isset($_SESSION['myusername']) and isset($_SESSION['mypassword']))
{
    $loggedin = true;
}
else
{
    $loggedin = false;
}

if (isset($_GET['pagereload']))
{
    $pagereload = $_GET['pagereload'];
}

if (!isset($_SESSION['product']))
{
    $_SESSION['product'] = 1;
}

?>