<?php

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

?>