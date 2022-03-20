<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['art_id']) and isset($_GET['art_url'])) {
    $art_id = $_GET['art_id'];
    $art_url = $_GET['art_url'];
} else {
    $art_id = null;
    $art_url = null;
}

if($art_id and $art_url){

    $data = json_decode(file_get_contents("php://input"));

    if($albums -> updateArt($art_id, $art_url)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Art updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update art.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>