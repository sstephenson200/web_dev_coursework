<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['username']) and isset($_GET['user_id'])) {
    $username = $_GET['username'];
    $user_id = $_GET['user_id'];
} else {
    $username = null;
    $user_id = null;
}

if($user_id and $username){

    $data = json_decode(file_get_contents("php://input"));

    if($users -> updateUsername($user_id, $username)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Username updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update username.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>