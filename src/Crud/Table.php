<?php

namespace Anmol\Webtoon\Crud;

class Table {
    protected $conn;

    public function __construct(\mysqli $conn){
        $this->conn = $conn;
    }   
    

    public function selectAll($tableName):object {
        $sql = "SELECT * from $tableName";
        return $this->conn->query($sql);
    }

    public function selectOne($attributeName, $tableName):object {
        $sql = "SELECT $attributeName from $tableName";
        return $this->conn->query($sql);
    }
}