<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['art_url'])) {
    $art_url = $_GET['art_url'];
} else {
    $art_url = null;
}

if($art_url){
    
    $data = json_decode(file_get_contents("php://input"));

    if($albums -> createArt($art_url)){
        $art_id = $db -> insert_id;
        http_response_code(200);
        echo json_encode(
            array("message" => "Art created.",
                    "art_id" => $art_id
                )
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create art.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>