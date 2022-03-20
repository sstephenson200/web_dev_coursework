<?php
session_start(); 

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id']) and isset($_GET['title']) and isset($_GET['length'])) {
    $title = $_GET['title'];
    $length = $_GET['length'];
    $album_id = $_GET['album_id'];
} else {
    $title = null;
    $length = null;
    $album_id = null;
}

if($album_id and $title and $length){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> addTrack($album_id, $title, $length)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Song added.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to add song.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>