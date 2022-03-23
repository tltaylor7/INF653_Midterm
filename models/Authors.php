<?php
    class Authors{
        //DB stuff
        private $conn;
        private $table = 'authors';

        //Post properties
        public $id;
        public $author;

        // Construct with DB
        public function __construct($db) {
        $this->conn = $db;
        }
        public function read(){
            $query = 'SELECT
            a.id,
            a.author
            FROM
             ' . $this->table . ' a
            ORDER BY
                a.id ASC';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single(){
            //create query
            $query = 'SELECT
                a.id,
                a.author
            FROM
             ' . $this->table . ' a
            WHERE
                a.id = ?
            LIMIT 0,1';      
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->author = $row['author'];
        
        }

        //Create Post
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    author = :author';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));


            //bind data
            $stmt->bindParam(':author', $this->author);


            //Execute query
            if($stmt->execute()) {
                return true; 
            }
            //Print error if something is wrong
            printf("Error: %s.\n", $stmt->error);

            return false;

        }

        //Update Post
        public function update(){
            //Create query
            $query = 'UPDATE ' . 
                    $this->table . '
                SET
                    id = :id,
                    author = :author
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));
            
            //bind data    
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);
        

            //Execute query
            if($stmt->execute()) {
                return true; 
            }
            //Print error if something is wrong
            printf("Error: %s.\n", $stmt->error);

            return false;

        }
        
        public function delete(){
            //Create query
            $query = 'DELETE FROM ' . $this->table .  ' WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':id', $this->id);

            //Execute query
            if($stmt->execute()) {
                return true; 
            }
            //Print error if something is wrong
            printf("Error: %s.\n", $stmt->error);

            return false;            
        }
}