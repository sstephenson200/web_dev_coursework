<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    $email = null;
}

$email = htmlspecialchars(strip_tags($email));
$email = $db -> real_escape_string($email);

$check_unique_query = "SELECT COUNT(email) FROM email_list WHERE email='$email'";
$result = $db -> query($check_unique_query);
$count = $result->fetch_assoc();

if($count['COUNT(email)'] == 0){
    $data = json_decode(file_get_contents("php://input"));

    if($users -> createEmailSignup($email)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Email added.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to add email.")
        );
    }
} else {
    echo json_encode(
        array("message" => "Email already exists.")
    );
}

?>