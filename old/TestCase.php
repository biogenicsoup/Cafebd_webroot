<?php
/**
 * Class TestCase
 *  */

class TestCase
{
    public $id;
    public $name;
    public $description;
    public $testcases;
    private $con;

    function __construct($id, $name, $description, $con)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->con = $con;
        $this->testcases = array();

        if ($this->id > 0) { //suite not persisted
            $sql = "SELECT tc.id FROM testcase tc JOIN Testcase_Suite ts ON ts.TestCase_id = tc.id WHERE ts.Suite_id = ?";
            $testCase_list = prepared_select($con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            foreach ($testCase_list as $row) {
                array_push();
            }
        }
    }
}