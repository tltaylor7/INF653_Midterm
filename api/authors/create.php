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

$author->author = $data->author;

if ((!isset($author->author))){
    echo json_encode(
        array('message' => 'Missing Required Parameters')
        );
        exit();
}

if($author->create()){
    echo json_encode(
        array(
            'id' => $db->lastInsertId(), 
            'author' => $author->author) 
        );
} else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}