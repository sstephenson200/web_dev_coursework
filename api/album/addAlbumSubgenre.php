<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['subgenre_id']) and isset($_GET['album_id'])) {
    $subgenre_id = $_GET['subgenre_id'];
    $album_id = $_GET['album_id'];
} else {
    $subgenre_id = null;
    $album_id = null;
}

if($subgenre_id and $album_id){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> addAlbumSubgenre($subgenre_id, $album_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Album subgenre added.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to added album subgenre.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>