<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quotes = new Quotes($db);

//Blog post query
$result = $quotes->read();
//Get row count
$num = $result->rowCount();

if ($num > 0){
    //Post array 
    $quote_arr = array();
    $quote_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => html_entity_decode($quote),
            'author' => $author,
            'category' => $category,
        );

        array_push($quote_arr['data'], $quote_item);
    }

    //Turn to JSON & output
    echo json_encode($quote_arr);
} else {
    echo json_encode(
        array('message' => 'No Quoutes Found')
    );
}