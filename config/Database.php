<?php 
    class Database {  
        private $url;
        private $conn;

        function __construct() {
            $this->$url = getenv('JAWSDB_URL');
            $this->conn = null;
        }
        
        //DB Connect
        public function connect() {
            
            $dbparts = parse_url($this->$url);
            
            $hostname = $dbparts['host'];
            $username = $dbparts['user'];
            $password = $dbparts['pass'];
            $database = ltrim($dbparts['path'],'/');
    
                try {
                    $this->$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
                    // set the PDO error mode to exception
                    $this->$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "Connected successfully";
                    }
                catch(PDOException $e)
                    {
                    echo "Connection failed: " . $e->getMessage();
                    }
            return $this->conn;
        }
    }