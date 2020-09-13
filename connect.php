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


function prepared_query($mysqli, $sql, $params, $types = "")
{
    //echo "sql = " . $sql . "\n";
    //echo "params = " . $params . "\n";
    //echo "types = " . $types . "\n";
    //echo "count(params) = " . count($params) . "\n";
    $types = $types ?: str_repeat("s", count($params));
    $stmt = $mysqli->prepare($sql);
    if (count($params) > 0)
    {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}

function prepared_select($mysqli, $sql, $params = [], $types = "") {
    return prepared_query($mysqli, $sql, $params, $types)->get_result();
}
?>