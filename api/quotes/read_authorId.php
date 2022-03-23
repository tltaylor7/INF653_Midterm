<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../models/Authors.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quotes = new Quotes($db);

//Get id
$quotes->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();

//Blog post query
$result = $quotes->read_authorId();
//Get row count
$num = $result->rowCount();

if ($num > 0){
    //Post array 
    $quote_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => html_entity_decode($quote),
            'author' => $author,
            'category' => $category,
        );

        array_push($quote_arr, $quote_item);
    }

    //Turn to JSON & output
    echo json_encode($quote_arr);
} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}