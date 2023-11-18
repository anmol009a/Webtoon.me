<?php
namespace Anmol\Webtoon\Crud;


class DatabaseHandler {
    private $host;
    private $username;
    private $password;
    private $database;
    protected $conn;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }

    private function connect() {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }    

    // Add more methods for specific operations like fetching data, inserting, updating, etc.
}
