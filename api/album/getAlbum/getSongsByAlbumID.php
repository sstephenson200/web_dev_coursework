<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
} else {
    $album_id = null;
}

$result = $albums -> getSongsByAlbumID($album_id);
$result = $result -> get_result();
$album_count = $result -> num_rows;

if($album_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $album = array (
            "song_title" => $song_title,
            "song_length" => $song_length
        );

        array_push($array, $album);
    }
    
    if($album_id){
        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid album_id value.")
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>