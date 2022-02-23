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

$result = $users -> getProfileDataByUserID($user_id);
$result = $result -> get_result();
$user_count = $result -> num_rows;

if($user_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $user = array (
            "user_name" => $user_name,
            "user_bio" => $user_bio,
            "location_code" => $location_code,
            "location_name" => $location_name,
            "user_contact_permissions" => $user_contact_permissions,
            "art_url" => $art_url

        );

        array_push($array, $user);
    }

    if($user_id){
        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid user_id value.")
        );
    }
    

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>