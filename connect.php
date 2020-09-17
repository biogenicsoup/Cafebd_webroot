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
    //echo "params = " . var_dump($params) . "\n";
    //echo "types = " . var_dump($types) . "\n";
    //echo "count(params) = " . count($params) . "\n";
    $types = $types ?: str_repeat("s", count($params));
    //var_dump($mysqli);
    //var_dump($types);
    $stmt = $mysqli->prepare($sql);
    if (count($params) > 0)
    {
        $stmt->bind_param($types, ...$params);
    }
    //var_dump($stmt);
    $stmt->execute();
    //var_dump($stmt);
    return $stmt;
}

function prepared_select($mysqli, $sql, $params = [], $types = "") {
    return prepared_query($mysqli, $sql, $params, $types)->get_result();
}
?>