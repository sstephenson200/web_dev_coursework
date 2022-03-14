<?php
session_start(); 

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    $email = null;
}

if($email) {
    $result = $users -> getUserIDByEmail($email);
    $result = $result -> get_result();
    $user_count = $result -> num_rows;

    if($user_count != 0){
        $array = array();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            $user = array (
                "user_id" => $user_id,
                "is_active" => $is_active  
            );
    
            array_push($array, $user);
        }

        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid email value.")
        );
    }
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Email not provided.")
    );
}

?>