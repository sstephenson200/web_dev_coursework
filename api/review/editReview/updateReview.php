<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['user_id']) and isset($_GET['album_id']) and isset($_GET['review_title']) and isset($_GET['review_text']) and isset($_GET['review_rating'])) {
    $user_id = $_GET['user_id'];
    $album_id = $_GET['album_id'];
    $review_title = $_GET['review_title'];
    $review_text = $_GET['review_text'];
    $review_rating = $_GET['review_rating'];
} else {
    $album_id = null;
    $user_id = null;
    $review_title = null;
    $review_text = null;
    $review_rating = null;
}

if($user_id and $album_id and $review_title and $review_text and $review_rating){

    $result = $reviews -> checkReviewExists($user_id, $album_id);
    $result = $result -> get_result();
    $review_count = $result -> num_rows;

    if($review_count != 0){ 

        $data = json_decode(file_get_contents("php://input"));

        if($reviews -> updateReview($user_id, $album_id, $review_title, $review_text, $review_rating)){
            http_response_code(200);
            echo json_encode(
                array("message" => "Review updated.")
            );
        } else {
            http_response_code(503);
            echo json_encode(
                array("message" => "Unable to update review.")
            );
        }

    } else {
        echo json_encode(
            array("message" => "Review doesn't exist.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>