<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quotes($db);

//Get id
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$quote->read_single();

//create array
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
);

if (is_null($quote->id)) {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
} else{
    echo json_encode($quote_arr);
 }
 