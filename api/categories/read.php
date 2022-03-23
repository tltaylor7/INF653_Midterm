<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();



//Instantiate category post object
$categories = new Categories($db);

//category read query
$result = $category->read();
//Get row count
$num = $result->rowCount();

//check if any categories
if ($num > 0){
    //Post array 
    $category_arr = array();
    $category_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        array_push($category_arr['data'], $category_item);
    }

    //Turn to JSON & output
    echo json_encode($category_arr);
} else {
    echo json_encode(
        array('message' => 'no categories found')
    );
}