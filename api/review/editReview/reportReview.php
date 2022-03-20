<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../review_api.php");

$database = new Database();
$db = $database -> getConn();

$reviews = new Review($db);

if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
} else {
    $review_id = null;
}

if($review_id){

    $data = json_decode(file_get_contents("php://input"));

    if($reviews -> reportReview($review_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Review reported.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to report review.")
        );
    }   

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>