<?php
session_start(); 

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['title']) and isset($_GET['art_id']) and isset($_GET['artist_id']) and isset($_GET['year_id'])) {
    $title = $_GET['title'];
    $art_id =  $_GET['art_id'];
    $artist_id =  $_GET['artist_id'];
    $year_id =  $_GET['year_id'];
} else {
    $title = null;
    $art_url =  null;
    $artist =  null;
    $year_value =  null;
}

if(isset($_GET['spotify_id'])){
    $spotify_id = $_GET['spotify_id'];
} else {
    $spotify_id = null;
}

if(isset($_GET['album_rating'])){
    $rating = $_GET['album_rating'];
} else {
    $rating = null;
}

if($title and $art_id and $artist_id and $year_id) {

    $data = json_decode(file_get_contents("php://input"));

    if($rating == null){
        if($albums -> createAlbum($title, 501, $spotify_id, $art_id, $artist_id, $year_id)){
            $album_id = $db -> insert_id;
            http_response_code(200);
            echo json_encode(
                array("message" => "Album created.",
                        "album_id" => $album_id
                    )
            );
        } else {
            http_response_code(503);
            echo json_encode(
                array("message" => "Unable to create album.")
            );
        }
    } else {
        if($albums -> createAlbum($title, $rating, $spotify_id, $art_id, $artist_id, $year_id)){
            $album_id = $db -> insert_id;
            http_response_code(200);
            echo json_encode(
                array("message" => "Album created.",
                        "album_id" => $album_id
                    )
            );
        } else {
            http_response_code(503);
            echo json_encode(
                array("message" => "Unable to create album.")
            );
        }
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>