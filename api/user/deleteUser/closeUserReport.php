<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];
} else {
    $report_id = null;
}

if($report_id){
    $data = json_decode(file_get_contents("php://input"));

    if($users -> closeUserReport($report_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "User reported deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to close user report.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>