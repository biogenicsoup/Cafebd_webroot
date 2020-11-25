<?php
include_once 'includeclasses.php';

class StepData
{
    private int $id;
    private string $name;
    private string $value;
    private int $stepid;
    private mysqli $con;

    function __construct($id, $con) {
        $this->id = $id;
        $this->con = $con;
        $this->name = "";
        $this->value = "";
        $this->stepid = -1;

        if ($this->id > 0) //data is persisted, get it
        {
            $sql = "SELECT sd.name, sd.value, sd.Step_id FROM stepdata sd WHERE id = ?";
            $sd_list = prepared_select($con, $sql, [$this->id])->fetch_all(MYSQLI_ASSOC);
            $this->name=$sd_list[0]['name'];
            $this->value=$sd_list[0]['value'];
            $this->stepid=$sd_list[0]['Step_id'];
        }
    }
    function update ($name, $value, $stepid) {
        $this->name = $name;
        $this->value = $value;
        $this->stepid = $stepid;
        
        if ($this->id == 0) //data is not persisted, create it
        {
            
            $sql = "INSERT INTO stepdata (name, value, Step_id) VALUE (?, ?, ?)";
            $stmt = prepared_query($this->con, $sql, [$this->name, $this->value, $this->stepid]);
            if ($this->con->insert_id < 1) {
                die("Could not persist stepdata with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
            $this->id = $this->con->insert_id;
        }
        else 
        {
            $this->save();
        }
    }
    function get_id() {
        return $this->id;
    }
    function get_name() {
        return $this->name;
    }
    function get_value() {
        return $this->value;
    }
    function get_stepid() {
        return $this->stepid;
    }
    function save() {
        if($this->id > 0) {
            $sql = "UPDATE stepdata SET name=?, value=?, Step_id=? WHERE id=?";
            $affected_rows = prepared_query($this->con, $sql, [$this->name, $this->value, $this->stepid, $this->id])->affected_rows;
            if ($affected_rows < 1) {
                die("Could not persist stepdata with name = " . $this->name . PHP_EOL .
                    "Error message = " . $this->con->error);
            }
        }
        else {
            die("Please create object before saving");
        }
    }
    function delete() {
        //delete data -> binding -> step
        $sql = "DELETE FROM stepdata sd WHERE sd.Step_id = ?";
        $stmt = prepared_query($this->con, $sql, [$this->id]);
    }
}
