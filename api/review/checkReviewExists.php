<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['user_id']) and isset($_GET['album_id'])) {
    $user_id = $_GET['user_id'];
    $album_id = $_GET['album_id'];
} else {
    $user_id = null;
    $album_id = null;
}

if($user_id and $album_id){

    $result = $reviews -> checkReviewExists($user_id, $album_id);
    $result = $result -> get_result();
    $review_count = $result -> num_rows;

    if($review_count == 0){
        
        http_response_code(200);
        echo json_encode(
            array("message" => "No review.")
        );
    } else {

        $array = array();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            $review = array (
                "review_id" => $review_id,
                "message" => "Posted review."
            );
    
            array_push($array, $review);
        }

        http_response_code(200);
        echo json_encode($array);
    }


} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>