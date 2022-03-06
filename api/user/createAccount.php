<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_SESSION['emailSignup']) and isset($_SESSION['usernameSignup']) and isset($_SESSION['password1Signup']) and isset($_SESSION['password2Signup'])) {
    $email = $_SESSION['emailSignup'];
    $username = $_SESSION['usernameSignup'];
    $password1 = $_SESSION['password1Signup'];
    $password2 = $_SESSION['password2Signup'];
} else {
    $email = null;
    $username = null;
    $password1 = null;
    $password2 = null;
}

$result = $users -> checkUserExists($email, $username);
$result = $result -> get_result();
$user_count = $result -> num_rows;

if($user_count == 0){
    
    $data = json_decode(file_get_contents("php://input"));

    if($users -> createAccount($email, $username, $password1)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Account created.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to create account.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Username and email are not unique.")
    );
}

?>