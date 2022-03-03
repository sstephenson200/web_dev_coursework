<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

$result = $users -> getUserLocationName();
$result = $result -> get_result();
$user_count = $result -> num_rows;

if($user_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $user = array (
            "location_name" => $location_name
        );

        array_push($array, $user);
    }
    
    http_response_code(200);
    echo json_encode($array);

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>