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

if($album_id){
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> deleteOwnedAlbumsByAlbumID($album_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Owned deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to delete owned.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>