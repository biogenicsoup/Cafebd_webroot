<?php
include_once 'includeclasses.php';

class Step
{
    private int $id;
    private string $name;
    private string $function;
    private mysqli $con;
    private int $productid;

    function __construct($id, $con) {
        $this->id = $id;
        $this->con = $con;

        if($this->id > 0) //get step
        {
            $sql="SELECT s.name, s.function, Product_id FROM Step s WHERE id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name = $data_list[0]['name'];
            $this->function = $data_list[0]['function'];
            $this->productid = $data_list[0]['Product_id'];
        }
    }

    function update($name, $function, $productid) {
        $this->name = $name;
        $this->function = $function;
        $this->productid = $productid;

        if($this->id == 0) //this is a new step
        {
            $sql = "INSERT INTO Step (`name`, `function`, Product_id) VALUES (?,?,?)";

            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->function, $this->productid])->affected_rows;
            $this->id = $this->con->insert_id;
        }
        else { //this is an existing module -> update
            $sql = "UPDATE step SET name=?, `function`=?, Product_id=? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->function, $this->productid, $this->id])->affected_rows;
        }
        if ($affected_rows < 1) {
            die("Could not update Step with name = " . $this->name . PHP_EOL .
                "Error message = " . $this->con->error);
        }
    }
    function bindToTestcase($testcaseId, $modulenumber) {
        if ($this->id > 0){
            //Is it bound already?
            $sql="SELECT * FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ? AND m.hidden=1";
            $data_list = prepared_select($this->con, $sql, [$this->id, $testcaseId])->fetch_all(MYSQLI_ASSOC);
            if(count($data_list)==0) // it is not bound
            {  // create hidden module and bind it to testcase then bind step to module
                //module
                $modulename = "testcase-".$testcaseId . " to step-" . $this->id;
                $sql = "INSERT INTO module (name, Product_id) VALUE (?, ?)";
                $stmt = prepared_query($this->con, $sql, [$modulename, $this->productid]);
                $moduleid = $this->con->insert_id;
                if($stmt->affected_rows < 1)
                {
                    die("Could not create module with name = ". $modulename . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
                // move modules down to create space 
                //flyt de andre moduler en tand ned
                $sql = "UPDATE testcase_module SET moduleNumber = moduleNumber +1 WHERE moduleNumber>=? AND TestCase_id=?";
                prepared_query($this->con, $sql, [$modulenumber, $testcaseId]);
                // bind to testcase
                $sql = "INSERT INTO testcase_module (TestCase_id, Module_id, moduleNumber) VALUES (?,?,?)";
                $stmt = prepared_query($this->con, $sql, [$testcaseId, $moduleid, $modulenumber]);
                if($stmt->affected_rows < 1)
                {
                    die("Could not bind module with id = " . $moduleid . "to testcase with id = " . $testcaseId . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
                // bind to step
                $sql = "INSERT INTO module_step (Module_id, Step_id) VALUES (?,?)";
                $stmt = prepared_query($this->con, $sql, [$moduleid, $this->id]);
                if($stmt->affected_rows < 1)
                {
                    die("Could not bind Step with id = " . $this->id . "to module with id = " . $moduleid . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
            }
        }
    }
    function unBindFromTestcase($testcaseId, $modulenumber) {
        $sql="SELECT ms.Module_id FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ? AND m.hidden = ?";
        $data_list = prepared_select($this->con, $sql, [$this->id, $testcaseId, 1])->fetch_all(MYSQLI_ASSOC);
        if(count($data_list)>0)
        {
            $moduleid = $data_list[0]['Module_id'];
            //delete bindings
            $sql = "DELETE FROM testcase_module WHERE TestCase_id=? AND Module_id=?";
            prepared_query($this->con, $sql, [$testcaseId, $moduleid]);
            $sql = "DELETE FROM module_step WHERE Step_id=? AND Module_id=?";
            prepared_query($this->con, $sql, [$this->id, $moduleid]);
            $sql = "DELETE FROM module WHERE id=?";
            prepared_query($this->con, $sql, [$moduleid]);
            //flyt de andre moduler en tand op
            $sql = "UPDATE testcase_module SET moduleNumber = moduleNumber -1 WHERE moduleNumber>=? AND TestCase_id=?";
            prepared_query($this->con, $sql, [$modulenumber, $testcaseId]);
        }
    }

    function bindToModule($moduleid, $stepNumber)
    {
        if ($this->id > 0){
            //flyt de andre steps en tand ned
            $sql = "UPDATE module_step SET stepNumber = stepNumber +1 WHERE stepNumber>=? AND Module_id=?";
            prepared_query($this->con, $sql, [$stepNumber, $moduleid]);
            //Is it bound already?
            $sql="SELECT * FROM module_step ms WHERE Module_id =? AND Step_id =? ";
            $data_list = prepared_select($this->con, $sql, [$moduleid, $this->id])->fetch_all(MYSQLI_ASSOC);
            if(count($data_list)==0)
            {   // bind module to step
                $sql = "INSERT INTO module_step (Module_id, Step_id, stepNumber) VALUES (?,?,?)";
                $stmt = prepared_query($this->con, $sql, [$moduleid, $this->id, $stepNumber]);
                if($stmt->affected_rows < 1)
                {
                    die("Could not bind Step with id = " . $this->id . "to module with id = " . $moduleid . PHP_EOL .
                        "Error message = " . $this->con->error);
                }
                //return $stmt;
            }
        }
    }
    function unBindFromModule($moduleid, $stepNumber)
    {
        //flyt de andre steps en tand op
        $sql = "UPDATE module_step SET stepNumber = stepNumber -1 WHERE stepNumber>=? AND Module_id=?";
        prepared_query($this->con, $sql, [$stepNumber, $moduleid]);
        $sql = "DELETE FROM module_step WHERE Step_id=? AND Module_id=?";
        prepared_query($this->con, $sql, [$this->id, $moduleid]);
    }
    
    
    
    function get_id() {
        return $this->id;
    }
    function get_connection() {
        return $this->con;
    }
    function get_name() {
        return $this->name;
    }
    function get_function() {
        return $this->function;
    }
    function set_name($name) {
        $this->name = $name;
        $this->save();
    }
    function set_function($function) {
        $this->function = $function;
        $this->save();
    }
    function set_nameAndFunction($name, $function) {
        $this->name = $name;
        $this->function = $function;
        $this->save();
    }

    /**
     * Returns a list of StepData objects
     * @return StepData[]
     */
    function get_stepData() {
        $sql = "SELECT * FROM stepdata WHERE Step_id = ?";
        $stepData_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        $stepData = array();
        foreach ($stepData_list as $row)
        {
            $stepData[] = new StepData($row['id'],$this->con);
        }
        return $stepData;
    }
    function get_value($key) {
        if($this->id > 0) {
            $sql="SELECT value FROM stepdata WHERE Step_id = ? AND name = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $key])->fetch_all(MYSQLI_ASSOC);

            if(count($data_list) == 1)
            {
                return $data_list[0]["value"];
            }
            else if(count($data_list) > 1)
            {
                $message = "More than one value found for key " . $key . ". Please sanitize your data (a random value is returned)";
                echo "<script type='text/javascript'>alert('$message');</script>";
                return $data_list[0]["value"];
            }
        }
        return "";
    }
    function get_stepdata_names()
    {
        $sql = "SELECT name FROM stepdata WHERE Step_id = ?";
        return prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
    }
    function get_stepnumber($testcaseId)
    {
        if($this->id > 0) {
            $sql="SELECT ms.stepNumber, tcm.moduleNumber FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $testcaseId])->fetch_all(MYSQLI_ASSOC);
            if(count($data_list)>0) {
                $stepNumber = (int)$data_list [0]['stepNumber'];
                $moduleNumber = (int)$data_list [0]['moduleNumber'];
                return ($stepNumber + $moduleNumber);
                /* modulenumber for hidden module is always zero,
                 * modelnumber for visible modules is the stepnumber for the first step,
                 * stepnumber is the offset of this step from the first step in the module */
            }
        }
        return -1;
    }
    function set_stepnumber($stepnumber, $testcaseId)
    {
        if($this->id > 0) {
            $sql="SELECT ms.stepNumber, m.id, m.hidden FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ? AND tcm.TestCase_id = ?";
            $data_list = prepared_select($this->con, $sql, [$this->id, $testcaseId])->fetch_all(MYSQLI_ASSOC);
            if(count($data_list)>0) {
                $stepStepNumber = (int)$data_list [0]['stepNumber'];
                $moduleid = (int)$data_list [0]['id'];
                $modulehidden = (int)$data_list [0]['hidden'];

                if($modulehidden == 1) //it is hidden
                {
                    $sql = "UPDATE module_step SET stepNumber = ? WHERE Module_id =? AND Step_id = ?";
                    $affected_rows = prepared_query($this->con, $sql, [$stepnumber, $moduleid, $this->id])->affected_rows;
                    if (count($affected_rows) < 1) {
                        die("Could not update stepnumber for step = " . $this->name . PHP_EOL .
                            "Error message = " . $this->con->error);
                    }
                }
                else {
                    $newmodulenumber = $stepnumber - $stepStepNumber;
                    $sql = "UPDATE testcase_module SET moduleNumber = ? WHERE Module_id =? AND TestCase_id = ?";
                    $affected_rows = prepared_query($this->con, $sql, [$newmodulenumber, $moduleid, $testcaseId])->affected_rows;
                    if (count($affected_rows) < 1) {
                        die("Could not update stepnumber for step = " . $this->name . PHP_EOL .
                            "Error message = " . $this->con->error);
                    }
                }
            }
        }
    }
    function save() {
        if($this->id > 0) {
            $sql = "UPDATE step SET name=?, `function`=? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->function, $this->id])->affected_rows;
            if (count($affected_rows) < 1) {
                die("Could not persist step with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
        }
        else
        {
            die("Please create object before saving");
        }
    }
    function delete() {
        //delete data -> binding -> step
        $sql = "DELETE FROM stepdata sd WHERE sd.Step_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql="SELECT m.id, m.hidden FROM module_step ms
                  JOIN module m on ms.Module_id = m.id
                  JOIN testcase_module tcm on m.id = tcm.Module_id 
                  WHERE ms.Step_id = ?";
        $data_list = prepared_select($this->con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
        foreach ($data_list as $row) {
            $moduleid = (int)$row['id'];
            $hiddenmodule = (int)$row['hidden'];
            if ($hiddenmodule == 1) // it IS hidden -> delete dummy module
            {
                $sql = "DELETE FROM testcase_module tm WHERE tm.Module_id = ?";
                prepared_query($this->con, $sql, [$moduleid]);
                $sql = "DELETE FROM module m WHERE m.id = ?";
                prepared_query($this->con, $sql, [$moduleid]);
            }
        }
        $sql = "DELETE FROM module_step ms WHERE ms.Step_id = ?";
        prepared_query($this->con, $sql, [$this->id]);
        $sql = "DELETE FROM step s WHERE s.id = ?";
        prepared_query($this->con, $sql, [$this->id]);
    }
}