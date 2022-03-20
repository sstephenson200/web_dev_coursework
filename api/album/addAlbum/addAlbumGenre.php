<?php
session_start(); 

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['genre_id']) and isset($_GET['album_id'])) {
    $genre_id = $_GET['genre_id'];
    $album_id = $_GET['album_id'];
} else {
    $genre_id = null;
    $album_id = null;
}

if($genre_id and $album_id){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> addAlbumGenre($genre_id, $album_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Album genre added.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to added album genre.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>