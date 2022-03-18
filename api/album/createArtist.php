<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['artist_name'])) {
    $artist = $_GET['artist_name'];
} else {
    $artist = null;
}

if($artist){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> createArtist($artist)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Artist created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create artist.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>