<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['emailLogin'])) {
    $email = $_GET['emailLogin'];
} else {
    $email = null;
}

$result = $users -> getUserPassword($email);
$result = $result -> get_result();
$user_count = $result -> num_rows;

if($user_count != 0){

    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $user = array (
            "user_id" => $user_id,
            "user_password" => $user_password,
            "is_active" => $is_active
        );

        array_push($array, $user);
    }

    http_response_code(200);
    echo json_encode($array);
    
} else {
    echo json_encode(
        array("message" => "Email incorrect.")
    );
} 

?>