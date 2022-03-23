<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog category object
$category = new Categories($db);

//Get id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$category->read_single();

//create array
$category_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

//Make JSON
if (is_null($category->id)) {
    echo json_encode(
        array('message' => 'categoryId Not Found')
    );
} else{
    echo json_encode($category_arr);
 }

