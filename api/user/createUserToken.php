<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['selector']) and isset($_GET['validator']) and isset($_GET['expiry_date']) and isset($_GET['user_id'])) {
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    $expiry_date = $_GET['expiry_date'];
    $user_id = $_GET['user_id'];
} else {
    $selector = null;
    $validator = null;
    $expiry_date = null;
    $user_id = null;
}

if($selector and $validator and $expiry_date and $user_id){
    $data = json_decode(file_get_contents("php://input"));

    if($users -> createUserToken($selector, $validator, $expiry_date, $user_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Token created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create token.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>