<?php
session_start(); 

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

    $result = $users -> checkValidUser($user_id);
    $result = $result -> get_result();
    $album_count = $result -> num_rows;

    if($album_count == 0){
        
        http_response_code(200);
        echo json_encode(
            array("message" => "Valid user.")
        );
    } else {

        http_response_code(200);
        echo json_encode(
            array("message" => "Invalid user.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>