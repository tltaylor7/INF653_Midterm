<?php 
    class Database {
        //DB param

        private $conn;
        private $url;

        function __construct() {
            $this->url = getenv('JAWSDB_URL');
            echo json_encode($this->url);
            $this->conn = null;
        }
        
        //DB Connect
        public function connect() {
            
            $dbparts = parse_url($this->url);
            echo json_encode($dbparts);

            $hostname = $dbparts['host'];
            echo json_encode($hostname);
            $username = $dbparts['user'];
            echo json_encode($username);
            $password = $dbparts['pass'];
            $database = ltrim($dbparts['path'],'/');

            
            try {
                $this->conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully";
                }
            catch(PDOException $e)
                {
                echo "Connection failed: " . $e->getMessage();
                }
            return $this->conn;
        }
    }