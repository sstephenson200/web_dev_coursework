<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
} else {
    $genre = null;
}

if($genre){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> createGenre($genre)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Genre created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create genre.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>