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
$quote = new Quotes($db);
$author = new Authors($db);
$category = new Categories($db);

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

$authorExists = isValid($authorId, $author);
// if categoryId exists:
$categoryExists = isValid($categoryId, $category);
// if quote id exists:
$idExists = isValid($id, $quote);


if ((isset($data->quote)) && (isset($data->categoryId)) && (isset($data->authorId))) {
    if ($authorExists) {
    echo json_encode(
        array('message' => 'authorId Not Found')
    );
    exit();

}else if (!$categoryExists) {
    echo json_encode(
        array('message' => 'categoryId Not Found')
    );
    exit();

}else if (!$idExists) {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
    exit();
    
}else if($quote->create()){
        echo json_encode(
            array(            
            'id' => $db->lastInsertId(), 
            'quote' => $quote->quote,
            'authorId' => $quote->authorId,
            'categoryId' => $quote->categoryId
            )
        );

}else{
    echo json_encode(
    array('message' => 'Missing Required Parameters')
    );
    exit();
    }
}


/*if($quote->create()){
    echo json_encode(
        array('message' => 'Quote Created')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Created')
    );
}
*/