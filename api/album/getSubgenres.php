<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

$result = $albums -> getSubgenres();
$result = $result -> get_result();
$album_count = $result -> num_rows;

if($album_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $album = array (
            $Subgenres
        );

        array_push($array, $album);
    }
    
    
    http_response_code(200);
    echo json_encode($array);

} else {
    http_response_code(200);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>