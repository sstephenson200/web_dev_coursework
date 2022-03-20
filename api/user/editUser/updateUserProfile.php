<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['art_url']) and isset($_GET['location_name']) and isset($_GET['user_bio']) and isset($_GET['user_id'])) {
    $art_url = $_GET['art_url'];
    $location_name = $_GET['location_name'];
    $user_bio = $_GET['user_bio'];
    $user_id = $_GET['user_id'];
} else {
    $art_url = null;
    $location_name = null;
    $user_bio = null;
    $user_id = null;
}

if($art_url and $location_name and $user_bio and $user_id){

    $data = json_decode(file_get_contents("php://input"));

    $users -> createArt($art_url);
    $art_id = $db -> insert_id;

    if($users -> updateUserProfile($user_id, $art_id, $location_name, $user_bio)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Profile updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update profile.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>