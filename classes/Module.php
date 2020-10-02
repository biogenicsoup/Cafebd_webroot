<?php


class Module
{
    public int $id;
    public string $name;
    public string $description;
    public int $hidden;
    public mysqli $con;

    function __construct($id, $con)
    {
        $this->id = $id;
        $this->con = $con;

        if ($this->id > 0) //get step
        {
            $sql = "SELECT m.name, m.description, m.hidden FROM module m WHERE id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name = $data_list[0]['name'];
            $this->description = $data_list[0]['description'];
            $this->hidden = $data_list[0]['hidden'];
        }
    }

    function create($name, $description, $hidden)
    {
        if ($this->id == 0) //this is a new module
        {
            //persist this step
            $this->name = $name;
            $this->description = $description;
            $this->hidden = $hidden;

            $sql = "INSERT INTO module (`name`, description, hidden) VALUES (?,?,?)";
            $stmt = prepared_query($this->con, $sql, [$name, $description, $hidden]);
            if ($stmt->affected_rows < 1) {
                die("Could not persist module with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
            $this->id = $this->con->insert_id;
        } else {
            die("This ID = " . $this->id . " already exist. Please use the constructor instead of calling create on an existing element");
        }
    }

    function bindToTestcase($testcaseId)
    {
        if ($this->id > 0) {
            //Is it bound already?
            $sql = "SELECT * FROM testcase_module tm WHERE tm.TestCase_id =? AND tm.module_id =?";
            $data_list = prepared_select($this->con, $sql, [$testcaseId, $this->id])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) == 0) {  // create hidden module and bind it to testcase then bind step to module
                //get module number (this will be placed last)
                $sql = "SELECT * FROM testcase_module tm WHERE tm.TestCase_id =?";
                $numelemets_list = prepared_select($this->con, $sql, [$testcaseId])->fetch_all(MYSQLI_ASSOC);

                // bind to testcase
                $sql = "INSERT INTO testcase_module (TestCase_id, Module_id, moduleNumber) VALUES (?,?,?)";
                $stmt = prepared_query($this->con, $sql, [$testcaseId, $this->id, count($numelemets_list)]);
                if ($stmt->affected_rows < 1) {
                    die("Could not bind module with id = " . $this->id . "to testcase with id = " . $testcaseId . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }

    function unBindFromTestcase($testcaseId)
    {
            //delete bindings
            $sql = "DELETE FROM testcase_module WHERE TestCase_id=? AND Module_id=?";
            prepared_query($this->con, $sql, [$testcaseId, $this->id]);

    }

    function bindToStep($stepid)
    {
        if ($this->id > 0) {
            //Is it bound already?
            $sql = "SELECT * FROM module_step ms WHERE Module_id =? AND Step_id =? ";
            $data_list = prepared_select($this->con, $sql, [$this->id, $stepid])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) == 0) {   // bind module to step
                //get stepnumber (last)
                $sql = "SELECT * FROM module_step ms WHERE Module_id =?";
                $numelements_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
                $numelements = count($numelements_list);
                if($this->hidden == 1 AND $numelements > 0) {
                    die("You cannot add more than one step to a hidden module: " . $this->id);
                }

                $sql = "INSERT INTO module_step (Module_id, Step_id, stepNumber) VALUES (?,?,?)";
                $stmt = prepared_query($this->con, $sql, [$this->id, $stepid, $numelements]);
                if ($stmt->affected_rows < 1) {
                    die("Could not bind Step with id = " . $stepid . "to module with id = " . $this->id . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }

    function unBindFromStep($stepid)
    {
        $sql = "DELETE FROM module_step WHERE Step_id=? AND Module_id=?";
        prepared_query($this->con, $sql, [$stepid, $this->id]);
        {
            if ($this->hidden == 1) //this is a hidden module and should be destroyed without contents
            {
                //remove from db
                $sql = "DELETE FROM module WHERE id=?";
                prepared_query($this->con, $sql, [$this->id]);
                //remove this reference (not sure this works, but the destructor class definitely does not work)
                //$this = null;
            }
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

    function set_name($name)
    {
        if($this->hidden == 1)
        {
            die("you cannot alter name and description for at hidden module");
        }
        $this->name = $name;
        $this->save();
    }

    function set_description($description)
    {
        if($this->hidden == 1)
        {
            die("you cannot alter name and description for at hidden module");
        }
        $this->description = $description;
        $this->save();
    }

    function set_nameAndDescription($name, $description)
    {
        if($this->hidden == 1)
        {
            die("you cannot alter name and description for at hidden module");
        }
        $this->name = $name;
        $this->description = $description;
        $this->save();
    }

    function get_steps()
    {
        $sql = "SELECT ms.Step_id FROM module_step ms WHERE Module_id = ? ORDER BY ms.stepNumber";
        $step_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $steps = array();
        foreach ($step_list as $row)
        {
            $steps[] = new Step($row['id'],$this->con);
        }
        return $steps;
    }

    function get_modulenumber($testcaseId)
    {
        if ($this->id > 0) {
            $sql = "SELECT tcm.moduleNumber FROM testcase_module tcm WHERE tcm.Module_id = ? AND tcm.TestCase_id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $testcaseId])->fetch_all(MYSQLI_ASSOC);
            if (count($data_list) > 0) {
                return (int)$data_list [0]['moduleNumber'];
            }
        }
        return -1;
    }

    function set_modulenumber($modulenumber, $testcaseId)
    {
        $sql = "UPDATE testcase_module SET moduleNumber = ? WHERE Module_id =? AND TestCase_id = ?";
        $affected_rows = prepared_query($this->con, $sql, [$modulenumber, $this->id, $testcaseId])->affected_rows;
        if (count($affected_rows) < 1) {
            die("Could not update modulenumber for module = " . $this->name . PHP_EOL .
                "Error message = " . $this->con->error);
        }
    }

    function save()
    {
        if ($this->id > 0) {
            $sql = "UPDATE module SET name=?, description=? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->description, $this->id])->affected_rows;
            if (count($affected_rows) < 1) {
                die("Could not persist module with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
        } else {
            die("Please create object before saving");
        }
    }

    function delete()
    {
        //delete data -> binding -> step
        $sql = "DELETE FROM module_step ms WHERE ms.Module_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM testcase_module tm WHERE tm.Module_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM module m WHERE m.id = ?";
        prepared_query($this->con, $sql, [$this->id]);

        /* toDo: it might be necessary to alter modulenumber for all following modules in testcases containg the deleted */
    }
}