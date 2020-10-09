<?php
include 'Suite.php';

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