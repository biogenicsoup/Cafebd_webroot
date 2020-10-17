<?php
include_once 'includeclasses.php';

/**
 * @var $con
 */

class Suite
{
    private int $id;
    private string $name;
    private string $description;
    private string $productid;
    private mysqli $con;

    function __construct($id, $con) {
        $this->id = $id;
        $this->con = $con;

        $this->name = "";
        $this->description = "";
        $this->productid = -1;

        if($this->id > 0) //get suite
        {
            $sql="SELECT s.name, s.description, s.Product_id FROM suite s WHERE id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name = $data_list[0]['name'];
            $this->description = $data_list[0]['description'];
            $this->productid = $data_list[0]['Product_id'];
        }
    }

    function update($name, $description, $productid) {
        $this->name = $name;
        $this->description = $description;
        $this->productid = $productid;

        if($this->id <= 0) //this is a new suite, create it
        {
            $sql = "INSERT INTO suite (name, description, Product_id) VALUES (?,?,?)";
            $stmt = prepared_query($this->con, $sql, [$this->name, $this->description, $this->productid]);
            if ($stmt->affected_rows < 1) {
                die("Could not persist suite with name = " . $this->name);
            }
            $this->id = $this->con->insert_id;
        }
        else $this->save();
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
    function get_productid() {
        return $this->productid;
    }

    /**
     * Returns a list of TestCase objects
     * @return TestCase[]
     */
    function get_testcases() {
        $sql = "SELECT tc.id FROM TestCase tc 
                JOIN testcase_suite tcs ON tcs.TestCase_id = tc.id WHERE tcs.Suite_id=?";
        $testCase_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);

        $testcases = array();
        foreach ($testCase_list as $row)
        {
            $testcases[] = new TestCase($row['id'],$this->con);
        }
        return $testcases;
    }

    function save(){
        $sql = "UPDATE suite SET name=?, description=?, Product_id=? WHERE id=?";
        $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->description, $this->productid, $this->id])->affected_rows;
        if (count($affected_rows) < 1) {
            die("Could not persist suite with name = " . $this->name . PHP_EOL .
                "Error message = " . $this->con->error);
        }
    }
    function delete(){
        //delete binding -> suite
        $sql = "DELETE FROM testcase_suite ts WHERE ts.Suite_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM suite s WHERE s.id = ?";
        prepared_query($this->con, $sql, [$this->id]);
    }

}
