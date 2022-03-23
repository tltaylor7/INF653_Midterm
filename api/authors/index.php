<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}
include_once '../../config/Database.php';
include_once '../../models/Authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$author = new Authors($db);

if ($method === 'GET') {
    
    if (isset($_GET['id'])) {
        require ('./read_single.php');
    }

    else{
        require ('./read.php');
    }
}

else if ($method === 'POST') {
    require ('./create.php');
}

else if ($method === 'PUT') {
    require ('./update.php');;
}

else if ($method === 'DELETE') {
    require ('./delete.php');;
}