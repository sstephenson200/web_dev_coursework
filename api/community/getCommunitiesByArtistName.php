<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("community_api.php");

$database = new Database();
$db = $database -> getConn();

$communities = new Community($db);

if (isset($_GET['artist_name'])) {
    $artist_name = $_GET['artist_name'];
} else {
    $artist_name = null;
}

$result = $communities -> getCommunitiesByArtistName($artist_name);
$result = $result -> get_result();
$community_count = $result -> num_rows;

if($community_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $community = array (
            "community_id" => $community_id,
            "community_name" => $community_name,
            "community_description" => $community_description,
            "art_url" => $art_url,
            "artist_name" => $artist_name
        );

        array_push($array, $community);
    }

    if($artist_name){
        http_response_code(200);
        echo json_encode($array);
    } else {
        http_response_code(400);
        echo json_encode(
            array("message" => "Invalid artist_name value.")
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>