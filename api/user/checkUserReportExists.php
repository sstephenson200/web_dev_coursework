<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['reporter']) and isset($_GET['reportee'])) {
    $reporter = $_GET['reporter'];
    $reportee = $_GET['reportee'];
} else {
    $reporter = null;
    $reportee = null;
}

if($reporter and $reportee){

    $result = $users -> checkUserReportExists($reporter, $reportee);
    $result = $result -> get_result();
    $review_count = $result -> num_rows;

    if($review_count == 0){
        
        http_response_code(200);
        echo json_encode(
            array("message" => "No report.")
        );
    } else {

        http_response_code(200);
        echo json_encode(
            array("message" => "Reported.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>