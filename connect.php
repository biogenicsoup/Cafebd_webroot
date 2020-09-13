<?php
include 'connectionvars.php';

/**
 * @var $host
 * @var $user
 * @var $pass
 * @var $db
 * @var $port
 * @var $charset
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $con = new mysqli($host, $user, $pass, $db, $port);
    $con->set_charset($charset);
} catch (\mysqli_sql_exception $e) {
    throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
}
unset($host, $db, $user, $pass, $charset); // we don't need them anymore

?>