<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quotes($db);

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));

$idExists = isValid($id, $quote);

// Set ID to update
$quote->id = $data->id;

/*if($quote->delete()){
    echo json_encode(
        array('id' => $quote->id)
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Found')
    );
}
*/

if($idExists){
    echo json_encode(
        array('id' => $quote->id)
    ); 
} else {
    echo json_encode(
        array('message' => 'Quote Not Found')
    );
}