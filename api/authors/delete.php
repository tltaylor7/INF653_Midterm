<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$author = new Authors($db);

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$author->id = $data->id;

if($author->delete()){
    echo json_encode(
        array('id' => $author->id)
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}