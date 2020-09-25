<?php
include 'connect.php';

/**
 * @var $con
 */

class Suite
{
    public $id;
    public $name;
    public $description;
    public $testcases;
    private $con;

    function __construct($id, $name, $description, $con) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->testcases = [];
        $this->con = $con;

        if($this->id > 0) { //suite is persisted
            // get testcases already in this suite
            $sql = "SELECT testCase_id id FROM TestCase_Suite WHERE suite_id=?";
           // $testcase_suite_list = prepared_select(this->con, $sql, [(int)$suiteId])->fetch_all(MYSQLI_ASSOC);
         //   foreach ($testcase_suite_list as $row) {
         //       array_push($this->testcases, $row["id"]);
            }

    }
    function get_id() {
        return $this->id;
    }
    function get_name() {
        return $this->name;
    }
    function get_description() {
        return $this->description;
    }
    function get_testcases() {
        return $this->testcases;
    }


}
