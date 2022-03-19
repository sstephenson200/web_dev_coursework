<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id']) and isset($_GET['song_title']) and isset($_GET['song_length'])) {
    $album_id = $_GET['album_id'];
    $song_title = $_GET['song_title'];
    $song_length = $_GET['song_length'];
} else {
    $album_id = null;
    $song_title = null;
    $song_length = null;
}

if($album_id and $song_title and $song_length){

    $data = json_decode(file_get_contents("php://input"));

    if($albums -> updateSongLength($album_id, $song_title, $song_length)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Song length updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update song length.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>