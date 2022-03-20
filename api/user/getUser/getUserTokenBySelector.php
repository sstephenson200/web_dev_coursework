<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../user_api.php");

$database = new Database();
$db = $database -> getConn();

$users = new User($db);

if (isset($_GET['selector'])) {
    $selector = $_GET['selector'];
} else {
    $selector = null;
}

if($selector) {

    $result = $users -> getUserTokenBySelector($selector);
    $result = $result -> get_result();
    $user_count = $result -> num_rows;

    if($user_count != 0) {
        $array = array();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            $user = array (
                "user_token_id" => $user_token_id,
                "user_token_selector" => $user_token_selector,
                "user_token_validator" => $user_token_validator,
                "expiry" => $expiry,
                "user_id" => $user_id
            );

            array_push($array, $user);
            http_response_code(200);
            echo json_encode($array);
        } 
    } else {
        echo json_encode(
            array("message" => "Invalid selector.")
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Selector not provided.")
    );
}

?>