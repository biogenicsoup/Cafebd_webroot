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

if (isset($_POST['productid']))
{
    $_SESSION['product'] = $_POST['productid'];
    
} else if (isset($_GET['productid']))
{
    $_SESSION['product'] = $_GET['productid'];
}

if (!isset($_SESSION['product']))
{
    $_SESSION['product'] = 1;
}
$productid=$_SESSION['product'];

?>