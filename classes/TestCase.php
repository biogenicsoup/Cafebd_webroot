<?php
/**
 * Class TestCase
 *  */

class TestCase
{
    public int $id;
    public string $name;
    public string $description;
    public int $testrailid;
    public int $scriptversion;
    public int $testtypeid;
    public mysqli $con;
    private int $productid;

    function __construct($id, $con)
    {
        $this->id = $id;
        $this->con = $con;
        $this->name = "";
        $this->description = "";
        $this->testrailid = 0;
        $this->scriptversion = 1;
        $this->testtypeid = 1;

        if ($this->id > 0) //get TestCase
        {
            $sql = "SELECT tc.name, tc.description, tc.testRailId, tc.scriptVersion, tc.TestType_id, tc.Product_id FROM testcase tc WHERE id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name = $data_list[0]['name'];
            $this->description = $data_list[0]['description'];
            $this->testrailid = $data_list[0]['$testrailid'];
            $this->scriptversion = $data_list[0]['scriptVersion'];
            $this->testtypeid = $data_list[0]['TestType_id'];
            $this->productid = $data_list[0]['Product_id'];
        }
    }

    function update($name, $description, $testrailid, $testtypeid, $productid)
    {
        $this->name = $name;
        $this->description = $description;
        $this->testrailid = $testrailid;
        $this->scriptversion = 1;
        $this->testtypeid = $testtypeid;
        $this->productid = $productid;

        if ($this->id == 0) //this is a new TestCase
        {
            //persist this step


            $sql = "INSERT INTO testcase (`name`, description, testRailId, scriptVersion, TestType_id, Product_id) VALUES (?,?,?,?,?,?)";
            $stmt = prepared_query($this->con, $sql, [$this->name, $this->description, $this->testrailid, $this->scriptversion, $this->testtypeid, $this->productid]);
            if ($stmt->affected_rows < 1) {
                die("Could not persist TestCase with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
            $this->id = $this->con->insert_id;
        }
        else $this->save();
    }

    function bindToSuite($suiteid)
    {
        if ($this->id > 0) {
            //Is it bound already?
            $sql = "SELECT * FROM testcase_suite tcs WHERE tcs.TestCase_id =? AND tcs.Suite_id =?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $suiteid])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) == 0) {  //not bound
                // bind to suite
                $sql = "INSERT INTO testcase_suite (TestCase_id, Suite_id) VALUES (?,?)";
                $stmt = prepared_query($this->con, $sql, [$this->id, $suiteid]);
                if ($stmt->affected_rows < 1) {
                    die("Could not bind Testcase with id = " . $this->id . "to suite with id = " . $suiteid . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }

    function unBindFromSuite($suiteid)
    {
        //delete bindings
        $sql = "DELETE FROM testcase_suite WHERE TestCase_id=? AND Suite_id=?";
        prepared_query($this->con, $sql, [$this->id, $suiteid]);
    }

    function bindToModule($moduleid)
    {
        if ($this->id > 0) {
            //Is it bound already?
            $sql = "SELECT * FROM testcase_module tcm WHERE tcm.TestCase_id =? AND tcm.Module_id =?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $moduleid])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) == 0) {  //not bound
                // bind to suite
                $sql = "INSERT INTO testcase_module (TestCase_id, Module_id) VALUES (?,?)";
                $stmt = prepared_query($this->con, $sql, [$this->id, $moduleid]);
                if ($stmt->affected_rows < 1) {
                    die("Could not bind Testcase with id = " . $this->id . "to module with id = " . $moduleid . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }

    function unBindFromModule($moduleid)
    {
        //delete bindings
        $sql = "DELETE FROM testcase_module WHERE TestCase_id=? AND Module_id=?";
        prepared_query($this->con, $sql, [$this->id, $moduleid]);
    }

    function bindToStep($stepid) {
        if ($this->id > 0){
            //Is it bound already?
            $sql="SELECT * FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ?";
            $data_list = prepared_select($this->con, $sql, [$stepid, $this->id])->fetch_all(MYSQLI_ASSOC);
            if(count($data_list)==0)
            {  // create hidden module and bind it to testcase then bind step to module
                //module
                $modulename = "testcase-".$this->id . " to step-" .$stepid;
                $sql = "INSERT INTO module(name) VALUE (?)";
                $stmt = prepared_query($this->con, $sql, [$modulename]);
                $moduleid = $this->con->insert_id;
                if($stmt->affected_rows < 1)
                {
                    die("Could not create module with name = ". $modulename . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
                // bind module to testcase
                $sql = "INSERT INTO testcase_module (TestCase_id, Module_id) VALUES (?,?)";
                $stmt = prepared_query($this->con, $sql, [$this->id, $moduleid]);
                if($stmt->affected_rows < 1)
                {
                    die("Could not bind module with id = " . $moduleid . "to testcase with id = " . $this->id . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
                // bind module to step
                $sql = "INSERT INTO module_step (Module_id, Step_id) VALUES (?,?)";
                $stmt = prepared_query($this->con, $sql, [$moduleid, $stepid]);
                if($stmt->affected_rows < 1)
                {
                    die("Could not bind Step with id = " . $this->id . "to module with id = " . $moduleid . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }
    function unBindFromStep($stepid) {
        $sql="SELECT ms.Module_id FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ? AND m.hidden = ?";
        $data_list = prepared_select($this->con, $sql, [$stepid, $this->id, 1])->fetch_all(MYSQLI_ASSOC);
        if(count($data_list)>0)
        {
            $moduleid = $data_list[0]['Module_id'];
            //delete bindings
            $sql = "DELETE FROM testcase_module WHERE TestCase_id=? AND Module_id=?";
            prepared_query($this->con, $sql, [$this->id, $moduleid]);
            $sql = "DELETE FROM module_step WHERE Step_id=? AND Module_id=?";
            prepared_query($this->con, $sql, [$stepid, $moduleid]);
            $sql = "DELETE FROM module WHERE id=?";
            prepared_query($this->con, $sql, [$moduleid]);
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

    function get_description()
    {
        return $this->description;
    }

    function get_testRailId()
    {
        return $this->testrailid;
    }

    function get_testType()
    {
        $sql="SELECT tt.name FROM testtype tt
                  JOIN testcase tc on tc.TestType_id = tt.id WHERE tc.id =?";
        $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        return $data_list[0]['name'];
    }

    function set_name($name)
    {
        $this->name = $name;
        $this->save();
    }

    function set_description($description)
    {
        $this->description = $description;
        $this->save();
    }

    function set_testRailId($testrailid)
    {
        $this->testrailid = $testrailid;
        $this->save();
    }

    function set_testType($testtypeid)
    {
        $this->testtypeid = $testtypeid;
        $this->save();
    }

    function set_all($name, $description, $testrailid, $testtypeid)
    {
        $this->name = $name;
        $this->description = $description;
        $this->testrailid = $testrailid;
        $this->testtypeid = $testtypeid;
        $this->save();
    }

    /**
     * Returns a list of Module objects
     * @return Module[]
     */
    function get_modules()
    {
        $sql = "SELECT tm.Module_id FROM testcase_module tm WHERE tm.TestCase_id = ? ORDER BY tm.moduleNumber";
        $module_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $modules = array();
        foreach ($module_list as $row)
        {
            $modules[] = new Module($row['id'],$this->con);
        }
        return $modules;

    }
    /**
     * Returns a list of Step objects
     * @return Step[]
     */
    function get_steps()
    {
        $modules = $this->get_modules();
        $steps = array();
        foreach ($modules as $mod)
        {
            array_merge($steps,$mod->get_steps());
        }
        return $steps;
    }

    function get_modulenumber($moduleId)
    {
        if ($this->id > 0) {
            $sql = "SELECT tcm.moduleNumber FROM testcase_module tcm WHERE tcm.Module_id = ? AND tcm.TestCase_id = ?";
            $data_list = prepared_select($this->con, $sql, [$moduleId, $this->id])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) > 0) {
                return (int)$data_list [0]['moduleNumber'];
            }
        }
        return -1;
    }

    function set_modulenumber($modulenumber, $moduleid)
    {
        $sql = "UPDATE testcase_module SET moduleNumber = ? WHERE Module_id =? AND TestCase_id = ?";
        $affected_rows = prepared_query($this->con, $sql, [$modulenumber, $moduleid, $this->id])->affected_rows;
        if (count($affected_rows) < 1) {
            die("Could not update modulenumber for module = " . $this->name . PHP_EOL .
                "Error message = " . $this->con->error);
        }
    }

    function save()
    {
        if ($this->id > 0) {
            $sql = "UPDATE testcase SET name=?, description=?, testRailId=?, scriptVersion=?, TestType_id=?, Product_id =? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->description, $this->testrailid, $this->scriptversion + 1, $this->testtypeid, $this->productid, $this->id])->affected_rows;
            if (count($affected_rows) < 1) {
                die("Could not persist testcase with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
        } else {
            die("Please create object before saving");
        }
    }

    function delete()
    {
        $sql = "DELETE FROM testcase_suite tcs WHERE tcs.TestCase_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM testcase_module tm WHERE tm.TestCase_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM testcase t WHERE t.id = ?";
        prepared_query($this->con, $sql, [$this->id]);

        /* toDo: it might be necessary to alter modulenumber for all following modules in testcases containg the deleted */
    }
}