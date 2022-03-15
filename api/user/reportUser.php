<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['reporter']) and isset($_GET['reportee']) and isset($_GET['reason'])) {
    $reporter = $_GET['reporter'];
    $reportee = $_GET['reportee'];
    $reason = $_GET['reason'];
} else {
    $reporter = null;
    $reportee = null;
    $reason = null;
}

if($reporter and $reportee and $reason){
    
    $data = json_decode(file_get_contents("php://input"));

    if($users -> reportUser($reporter, $reportee, $reason)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Reported.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to report user.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
} 

?>