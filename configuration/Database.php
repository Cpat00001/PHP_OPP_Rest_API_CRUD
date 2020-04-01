<?php

class Database{
    //DB props
    private $host = 'localhost';
    private $username = "root";
    private $dbname = "news";
    private $password = "1236";
    private $conn;

    // connect to DB
    public function connect(){
        $this->conn = null;
        try{
            //$this->conn = new PDO("mysql:host=" . $this->host . " ;dbname= " . $this->dbname,$this->username,$this->password);
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
            //set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "DB Connected...";
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}