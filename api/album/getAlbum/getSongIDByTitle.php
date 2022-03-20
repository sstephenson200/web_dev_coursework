<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id']) and isset($_GET['song_title'])) {
    $album_id = $_GET['album_id'];
    $song_title = $_GET['song_title'];
} else {
    $album_id = null;
    $song_title = null;
}

if($album_id and $song_title){
    $result = $albums -> getSongIDByTitle($album_id, $song_title);
    $result = $result -> get_result();
    $album_count = $result -> num_rows;

    if($album_count != 0) {
        $array = array();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            $album = array (
                "song_id" => $song_id
            );

            array_push($array, $album);
        }
    
        http_response_code(200);
        echo json_encode($array);

    }
    
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>