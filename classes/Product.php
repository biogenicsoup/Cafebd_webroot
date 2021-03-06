<?php
include_once 'includeclasses.php';

class Product
{
    public int $id;
    public string $name;
    public mysqli $con;

    function __construct($id, $con)
    {
        $this->id = $id;
        $this->con = $con;
        $this->name = "";

        if ($this->id > 0) //get step
        {
            $sql = "SELECT p.name FROM product p WHERE p.id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name = $data_list[0]['name'];
        }
    }

    function update($name)
    {
        $this->name = $name;
        if ($this->id == 0) //this is a new TestCase
        {
            $sql = "INSERT INTO product (`name`) VALUES (?)";
            $stmt = prepared_query($this->con, $sql, [$this->name]);
            if ($stmt->affected_rows < 1) {
                die("Could not persist Product with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
            $this->id = $this->con->insert_id;
        } else {
            $this->save();
        }
    }


    function get_id()
    {
        return $this->id;
    }

    function get_name()
    {
        return $this->name;
    }

    function set_name($name)
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * Returns a list of Suite objects
     * @return Suite[]
     */
    function get_suites()
    {
        $sql = "SELECT s.id FROM suite s WHERE s.Product_id = ? ORDER BY s.name";
        $suite_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $suites = array();
        foreach ($suite_list as $row) {
            $suites[] = new Suite($row['id'], $this->con);
        }
        return $suites;
    }
    
    /**
     * Returns a list of TestCase objects
     * @return TestCase[]
     */
    function get_testcases()
    {
        $sql = "SELECT tc.id FROM testcase tc WHERE tc.Product_id = ? ORDER BY tc.name";
        $testcase_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $testcases = array();
        foreach ($testcase_list as $row) {
            $testcases[] = new TestCase($row['id'], $this->con);
        }
        return $testcases;
    }
    
    /**
     * Returns a list of Module objects
     * @return Module[]
     */
    function get_modules()
    {
        $sql = "SELECT m.id FROM module m WHERE m.Product_id = ? ORDER BY m.name";
        $module_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $modules = array();
        foreach ($module_list as $row) {
            $modules[] = new Module($row['id'], $this->con);
        }
        return $modules;
    }
    
    /**
     * Returns a list of Module objects
     * @return Module[]
     */
    function get_steps()
    {
        $sql = "SELECT s.id FROM Step s WHERE s.Product_id = ? ORDER BY s.name";
        $step_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $steps = array();
        foreach ($step_list as $row) {
            $steps[] = new Step($row['id'], $this->con);
        }
        return $steps;
    }

    function save()
    {
        if ($this->id > 0) {
            $sql = "UPDATE product SET name=? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->id])->affected_rows;
            if (count($affected_rows) < 1) {
                die("Could not persist product name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
        } else {
            die("Please create object before saving");
        }
    }

    function delete()
    {
        $suites = $this->get_suites();
        foreach ($suites as $suite){
            $testcases = $suite->get_testcases();
            foreach ($testcases as $testcase){
                $steps = $testcase->get_steps();
                foreach ($steps as $step){
                    $step->delete();
                }
                $modules = $testcase->get_modules();
                foreach ($modules as $module){
                    $module->delete();
                }
                $testcase->delete();
            }
            $suite->delete();
        }
        $sql = "DELETE FROM product p WHERE p.id = ?";
        prepared_query($this->con, $sql, [$this->id]);
    }
}