<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['email']) and isset($_GET['user_id'])) {
    $email = $_GET['email'];
    $user_id = $_GET['user_id'];
} else {
    $email = null;
    $user_id = null;
}

if($user_id and $email){

    $data = json_decode(file_get_contents("php://input"));

    if($users -> updateUserEmail($user_id, $email)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Email updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update email.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>