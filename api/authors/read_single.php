<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog author object
$author = new Authors($db);

//Get id
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$author->read_single();

//create array
$author_arr = array(
    'id' => $author->id,
    'author' => $author->author
);

//Make JSON
if (is_null($author->id)) {
    echo json_encode(
        array('message' => 'authorId Not Found')
    );
} else{
    echo json_encode($author_arr);
 }