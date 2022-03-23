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

if ((!isset($category->category)) || (!isset($category->id))) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
        );
        exit();
}
$category->category = $data->category;

if($category->create()){
    echo json_encode(
        array(
            'id' => $db->lastInsertId(), 
            'category' => $this->category)
        );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}