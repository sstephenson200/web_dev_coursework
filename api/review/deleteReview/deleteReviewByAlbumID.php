<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
} else {
    $album_id = null;
}

if($album_id){
    $data = json_decode(file_get_contents("php://input"));

    if($reviews -> deleteReviewByAlbumID($album_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Review deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to delete review.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>