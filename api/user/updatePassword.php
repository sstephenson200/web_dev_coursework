<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['password']) and isset($_GET['user_id'])) {
    $password = $_GET['password'];
    $user_id = $_GET['user_id'];
} else {
    $password = null;
    $user_id = null;
}

if($user_id and $password){

    $data = json_decode(file_get_contents("php://input"));

    if($users -> updatePassword($password, $user_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Password updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update password.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>