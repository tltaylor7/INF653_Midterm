<?php
    class Categories{
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Post properties
        public $id;
        public $category;

        // Construct with DB
        public function __construct($db) {
        $this->conn = $db;
        }
        public function read(){
            $query = 'SELECT
                c.id,
                c.category
            FROM
             ' . $this->table . ' c
            ORDER BY
                c.id ASC';
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single(){
            //create query
            $query = 'SELECT
                c.id,
                c.category
            FROM
             ' . $this->table . ' c
            WHERE
                c.id = ?
            LIMIT 0,1';      
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->category = $row['category'];
        
        }

        //Create Post
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                category = :category';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));


            //bind data
            $stmt->bindParam(':category', $this->category);


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
                    category = :category
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data 
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));
           

            //bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);
            

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