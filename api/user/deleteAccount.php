<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = null;
}

if($user_id){

    $data = json_decode(file_get_contents("php://input"));

    if($users -> deleteAccount($user_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Account deleted.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to delete account.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>