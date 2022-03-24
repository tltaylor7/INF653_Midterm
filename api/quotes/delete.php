<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();


$quote = new Quotes($db);

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));


// Set ID to update
$quote->id = $data->id;

if($quote->delete()){
    echo json_encode(
        array('id' => $quote->id)
    );
} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}


