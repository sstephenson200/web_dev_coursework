<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = null;
}

if($user_id) {

    if($users -> checkUserActive($user_id)) {
        $result = $users -> checkUserActive($user_id);
        $result = $result -> get_result();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            
            if($row['is_active'] == 1){
                http_response_code(200);
                echo json_encode(
                    array("message" => "Account active.")
                );
            } else {
                echo json_encode(
                    array("message" => "Account deleted.")
                );
            }
    
        }
    
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid user_id value.")
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>