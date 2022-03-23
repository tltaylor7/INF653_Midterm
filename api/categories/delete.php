<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Categories($db);

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$category->id = $data->id;

if($category->delete()){
    echo json_encode(
        array('message' => 'Category Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );
}