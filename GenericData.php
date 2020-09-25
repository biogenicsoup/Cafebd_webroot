<?php


class GenericData
{
    public $id;
    public $key;
    public $value;
    public $stepid;
    public $testcaseid;
    public $con;

    function __construct($id, $key, $value, $stepid, $testcaseid, $con) {
        $this->id = $id;
        $this->key = $key;
        $this->value = $value;
        $this->stepid = $stepid;
        $this->testcaseid = $testcaseid;
        $this->con = $con;

        if ($this->id == 0) //data is not persisted
        {
            $sql = "INSERT INTO genericdata (`key`, value, TestCase_Step_Step_id, TestCase_Step_TestCase_id) VALUE (?, ?, ? ,?)";
            $stmt = prepared_query($this->con, $sql, [$this->key, $this->value, $this->stepid, $this->testcaseid]);
            $this->id = $con->insert_id;
        }
    }
    function get_id() {
        return $this->id;
    }
    function get_key() {
        return $this->key;
    }
    function get_value() {
        return $this->value;
    }
    function get_stepid() {
        return $this->stepid;
    }
    function get_testcaseid() {
        return $this->testcaseid;
    }
}
