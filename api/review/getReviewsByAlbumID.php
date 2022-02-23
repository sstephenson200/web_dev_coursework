<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
} else {
    $album_id = null;
}

$result = $reviews -> getReviewsByAlbumID($album_id);
$result = $result -> get_result();
$review_count = $result -> num_rows;

if($review_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $review = array (
            "review_id" => $review_id,
            "review_title" => $review_title,
            "review_text" => $review_text,
            "review_rating" => $review_rating,
            "review_date" => $review_date,
            "user_id" => $user_id,
            "user_name" => $user_name,
            "art_url" => $art_url
        );

        array_push($array, $review);
    }

    if($album_id){
        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid album_id value.")
        );
    }
    

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>