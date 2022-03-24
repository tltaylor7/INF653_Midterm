<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../models/Categories.php';
include_once '../../models/Authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$quote = new Quotes($db);

if ($method === 'GET') {
    
    if (isset($_GET['id'])) {
        include ('read_single.php');
    }

    else if ($method === 'GET' && isset($_GET['authorId']) && !(isset($_GET['categoryId']))) {
        include ('read_authorId.php');
    }

    else if ($method === 'GET' && isset($_GET['categoryId']) && !(isset($_GET['authorId']))) {
        include ('read_catId.php');
    }

    else if ($method === 'GET' && isset($_GET['authorId']) && isset($_GET['categoryId'])) {
        include ('read_cat_authorId.php');
    }

    else{
        include('read.php');
    }
}
else if ($method === 'POST') {
    include ('create.php');
}

else if ($method === 'PUT') {
    include ('update.php');
}

else if ($method === 'DELETE') {
    include ('delete.php');
}
