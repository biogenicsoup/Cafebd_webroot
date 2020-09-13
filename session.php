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

if (!$loggedin)
{
    include 'header.php';
    echo "<br>";
    echo "<i> Du er ikke logget ind og kan ikke oprette/redigere personer! </i><br>";
    echo "<a href='index.php'>Log ind</a>";
    include 'footer.php';
    exit();
}
?>