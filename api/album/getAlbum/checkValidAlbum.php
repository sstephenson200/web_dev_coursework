<?php
session_start(); 

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

if($album_id){

    $result = $albums -> checkValidAlbum($album_id);
    $result = $result -> get_result();
    $album_count = $result -> num_rows;

    if($album_count == 0){
        
        http_response_code(200);
        echo json_encode(
            array("message" => "No album.")
        );
    } else {

        http_response_code(200);
        echo json_encode(
            array("message" => "Album exists.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>