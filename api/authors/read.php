<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../function/isValid.php';
include_once '../../models/Categories.php';
include_once '../../models/Authors.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();



//Instantiate Author post object
$author = new Authors($db);

//Author read query
$result = $author->read();
//Get row count
$num = $result->rowCount();

//check if any categories
if ($num > 0){
    //Post array 
    $author_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author,
        );

        array_push($author_arr, $author_item);
    }

    //Turn to JSON & output
    echo json_encode($author_arr);
} else {
    echo json_encode(
        array('message' => 'no categories found')
    );
}