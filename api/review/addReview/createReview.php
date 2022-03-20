<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['album_id']) and isset($_GET['user_id']) and isset($_GET['reviewTitle']) and isset($_GET['reviewText']) and isset($_GET['reviewRating'])) {
    $album_id = $_GET['album_id'];
    $user_id = $_GET['user_id'];
    $title = $_GET['reviewTitle'];
    $text = $_GET['reviewText'];
    $rating = $_GET['reviewRating'];
} else {
    $album_id = null;
    $user_id = null;
    $title = null;
    $text = null;
    $rating = null;
}

if($album_id and $user_id and $title and $text and $rating){
    $data = json_decode(file_get_contents("php://input"));

    if($reviews -> createReview($user_id, $album_id, $title, $text, $rating)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Review created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create review.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>