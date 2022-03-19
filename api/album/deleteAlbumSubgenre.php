<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['album_id']) and isset($_GET['subgenre_id'])) {
    $album_id = $_GET['album_id'];
    $subgenre_id = $_GET['subgenre_id'];
} else {
    $album_id = null;
    $subgenre_id = null;
}

if($album_id and $subgenre_id){
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> deleteAlbumSubgenre($album_id, $subgenre_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Album subgenre deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to delete album subgenre.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>