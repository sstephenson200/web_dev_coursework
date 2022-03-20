<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];
} else {
    $song_id = null;
}

if($song_id){
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> deleteTrack($song_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Song deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to delete song.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>