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

//Get Raw posted data
$data = json_decode(file_get_contents("php://input"));

$quote = new Quotes($db);


$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

if ((isset($data->quote)) || (isset($data->categoryId)) || (isset($data->authorId))) {
    echo json_encode(
array('message' => 'Missing Required Parameters')
);
exit();
}
if ($quote->create()){
    echo json_encode(
        array(            
        'id' => $db->lastInsertId(),  
        'quote' => $quote->quote,
        'authorId' => $quote->authorId,
        'categoryId' => $quote->categoryId
        )
    );

}else {
    echo json_encode(
        array('message' => 'No QuotesFound')
    );
}