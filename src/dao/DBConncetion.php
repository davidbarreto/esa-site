<?php

class DBConnection {
    
    private static $instance;
    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $conn;
    
    private function __construct() {

        $this->connect();
    }
    
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new DBConnection();
        }
        
        return self::$instance;
    }

    private function connect() {

        $config_file = __DIR__.'/../../conf/esa.ini';

        if (!isset($this->conn)) {

            $config = parse_ini_file($config_file);

            $this->servername = $config['host'];
            $this->dbname = $config['dbname'];
            $this->username = $config['username'];
            $this->password = $config['password'];

            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
        }
    }
    
    public function getConnection() {
        $this->connect();
        return $this->conn;
    }
}

