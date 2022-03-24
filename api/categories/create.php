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

$category->category = $data->category;

if ((!isset($category->category))){
    echo json_encode(
        array('message' => 'Missing Required Parameters')
        );
        exit();
}


if($category->create()){
    echo json_encode(
        array(
            'id' => $db->lastInsertId(), 
            'category' => $category->category)
        );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}