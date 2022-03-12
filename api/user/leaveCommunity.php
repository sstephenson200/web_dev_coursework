<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['user_id']) and isset($_GET['community_id'])) {
    $user_id = $_GET['user_id'];
    $community_id = $_GET['community_id'];
} else {
    $user_id = null;
    $community_id = null;
}

if($user_id and $community_id){
    $data = json_decode(file_get_contents("php://input"));

    if($users -> leaveCommunity($user_id, $community_id)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Left community.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to leave community.")
        );
    }
} else {
    echo json_encode(
       array("message" => "Data not provided.")
    );
}

?>