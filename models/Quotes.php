<?php
    class Quotes {
    //DB stuff
    private $conn;
    private $table = 'quotes';

    //Post properties
    public $id;
    public $quote;   
    public $categoryId;
    public $authorId;
    public $author;
    public $category;

    // Construct with DB
    public function __construct($db) {
        $this->conn = $db;
        }

        //GET posts
        public function read(){
            //create query
            $query = 'SELECT
                a.author,
                c.category,
                q.id,
                q.quote,
                q.categoryId,
                q.authorId
                FROM
                ' . $this->table . ' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                ORDER BY 
                    q.id ASC';
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            // create query
            $query = 'SELECT 
                    c.category AS category, 
                    q.id, 
                    q.categoryId, 
                    a.author AS author, 
                    q.authorId,
                    q.quote
                    FROM 
                        ' . $this->table . ' q
                    LEFT JOIN 
                        categories c ON q.categoryId = c.id
                    LEFT JOIN 
                        authors a ON q.authorId = a.id
                    WHERE 
                    q.id = ?
                    LIMIT 0,1';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->quote = $row['quote'];
        $this->authorId = $row['authorId'];
        $this->categoryId = $row['categoryId'];
    }

        public function read_authorId(){
            //create query
            $query = 'SELECT
                    c.category AS category, 
                    q.id, 
                    q.categoryId, 
                    a.author AS author, 
                    q.authorId,
                    q.quote
                FROM
                ' . $this->table . ' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.authorId = ?
                ORDER BY 
                    q.id ASC';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->authorId);

            $stmt->execute();

            return $stmt;
        }

        public function read_catId(){
            //create query
            $query = 'SELECT
                    c.category AS category, 
                    q.id, 
                    q.categoryId, 
                    a.author AS author, 
                    q.authorId,
                    q.quote
                FROM
                ' . $this->table . ' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.categoryId = ?
                ORDER BY 
                    q.id ASC';
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->categoryId);

            $stmt->execute();

            return $stmt;
        }

        public function read_cat_authorId(){
            //create query
            $query = 'SELECT
                c.category AS category, 
                q.id, 
                q.categoryId, 
                a.author AS author, 
                q.authorId,
                q.quote
                FROM
                ' . $this->table . ' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.categoryId = ? AND q.authorId = ?';
                    

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->categoryId);
            $stmt->bindParam(2, $this->authorId);

            $stmt->execute();

            return $stmt;
        }

        //Create Post
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    id = :id,
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            //bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

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
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId
                    WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            

            //bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);
            

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