<?php

header("Content-Type: application/json");

include("../../../connections/dbconn.php");
include("../community_api.php");

$database = new Database();
$db = $database -> getConn();

$communities = new Community($db);

if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];
} else {
    $community_id = null;
}

$result = $communities -> getCommunitySizeByCommunityID($community_id);
$result = $result -> get_result();
$community_count = $result -> num_rows;

if($community_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $community = array (
            "MemberCount" => $MemberCount
        );

        array_push($array, $community);
    }

    if($community_id){
        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid community_id value.")
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>