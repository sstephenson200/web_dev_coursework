<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['year_value'])) {
    $year = $_GET['year_value'];
} else {
    $year = null;
}

if($year){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> createYear($year)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Year created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create year.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>