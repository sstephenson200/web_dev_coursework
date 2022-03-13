<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['permissions']) and isset($_GET['user_id'])) {
    $permissions = $_GET['permissions'];
    $user_id = $_GET['user_id'];
} else {
    $permissions = null;
    $user_id = null;
}

if($user_id and ($permissions==1 or $permissions==0)){

    $data = json_decode(file_get_contents("php://input"));

    if($users -> updateUserContactPermissions($user_id, $permissions)){
        http_response_code(200);
        echo json_encode(
            array("message" => "Contact permissions updated.")
        );
    } else {
        http_response_code(503);
        echo json_encode(
            array("message" => "Unable to update permissions.")
        );
    }

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>