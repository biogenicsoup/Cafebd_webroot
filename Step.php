<?php


class Step
{
    private $id;
    private $name;
    private $function;
    private $testcaseid;
    public $con;

    function __construct($id, $name, $function, $testcaseid, $con) {
        $this->id = $id;
        $this->name = $name;
        $this->function = $function;
        $this->testcaseid = $testcaseid;
        $this->con = $con;

        if($this->id == 0) //this is a new step
        {
            //persist this step
            $sql = "INSERT INTO Step (`name`, `function`) VALUES (?,?)";
            //INSERT INTO `cafedb_rm_edition`.`step` (`name`, `function`) VALUES ('jhgf', 'jhgfjhg');

            $stmt = prepared_query($this->con, $sql, [$name, $function]);
            if($stmt->affected_rows < 1)
            {
                die("Could not persist Step with name = " . $this->name);
            }
            $this->id = $con->insert_id;

            //bind step to testcase
            $sql = "INSERT INTO testcase_step (TestCase_id, Step_id) VALUES (?,?)";
            $stmt = prepared_query($con, $sql, [$this->testcaseid, $this->id]);
            if($stmt->affected_rows < 1)
            {
                die("Could not bind Step with id = " . $this->id . "to testcase with id = " . $this->testcaseid);
            }
        }
    }
    function get_id() {
        return $this->id;
    }
    function get_function() {
        return $this->function;
    }
    function get_data() {
        $sql="SELECT * FROM genericdata WHERE TestCase_Step_id = ? AND TestCase_Step_TestCase_id = ?";
        $data_list = prepared_select($this->con, $sql, [$this->id, $this->testcaseid])->fetch_all(MYSQLI_ASSOC);
        return $data_list;
    }
    function get_value($key) {
        $sql="SELECT value FROM genericdata WHERE TestCase_Step_id = ? AND TestCase_Step_TestCase_id = ? AND `key` = ?";
        $data_list = prepared_select($this->con, $sql, [$this->id, $this->testcaseid, $key])->fetch_all(MYSQLI_ASSOC);
        $returnvar = "";
        if(count($data_list == 1))
        {
            $returnvar = $data_list[0]["value"];
        }
        else if(count($data_list > 1))
        {
            $message = "More than one value found for key " . $key . ". Please sanitize your data (one random value is returned)";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $returnvar = $data_list[0]["value"];
        }
        return $returnvar;
    }
    function delete() {
        //delete data -> binding -> step
        $sql = "DELETE FROM genericdata gd WHERE gd.TestCase_Step_Step_id = ?";
        $stmt = prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM testcase_step ts WHERE ts.Step_id = ?";
        $stmt = prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM step s WHERE s.id = ?";
        $stmt = prepared_query($this->con, $sql, [$this->id]);
    }
}