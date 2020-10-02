<?php
/**
 * @var $loggedin
 */
if (!$loggedin)
{
    echo "<br>";
    echo "<i> Du er ikke logget ind og kan ikke oprette/redigere autotest data! </i><br>";
    echo "<a href='index.php'>Home</a>";
    exit();
}