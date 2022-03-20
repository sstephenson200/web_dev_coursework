<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id']) and isset($_GET['title']) and isset($_GET['artist_id']) and isset($_GET['art_id']) and isset($_GET['year_id'])) {
    $album_id = $_GET['album_id'];
    $title = $_GET['title'];
    $artist_id = $_GET['artist_id'];
    $art_id = $_GET['art_id'];
    $year_id = $_GET['year_id'];
} else {
    $album_id = null;
    $title = null;
    $artist_id = null;
    $art_id = null;
    $year_id = null;
}

if(isset($_GET['spotify_id'])){
    $spotify_id = $_GET['spotify_id'];
} else {
    $spotify_id = null;
}

if(isset($_GET['rating'])){
    $rating = $_GET['rating'];
} else {
    $rating = null;
}

if($album_id and $title and $artist_id and $art_id and $year_id){

    $data = json_decode(file_get_contents("php://input"));

    if($rating == null){
        $rating = 501;
    }

    if($albums -> updateAlbum($album_id, $title, $artist_id, $art_id, $spotify_id, $rating, $year_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Album updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update album.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>