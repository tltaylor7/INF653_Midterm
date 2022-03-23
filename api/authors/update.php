<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../function/isValid.php';
include_once '../../models/Categories.php';
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
$author->author = $data->author;

if ((!isset($author->author)) || (!isset($author->id))) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
        );
        exit();
}


if($author->update()){
    echo json_encode(
        array('id' => $author->id, 
        'author' => $author->author)
    );
} 