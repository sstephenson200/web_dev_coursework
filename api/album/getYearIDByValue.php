<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if(isset($_GET['year_value'])){
    $year = $_GET['year_value'];
} else {
    $year = null;
}

if($year){
    $result = $albums -> getYearIDByValue($year);
    $result = $result -> get_result();
    
    if($result){
        $array = array();

        while($row = $result -> fetch_assoc()) {
            extract($row);
            $album = array (
                "year_value_id" => $year_value_id
            );

            array_push($array, $album);

        }

        http_response_code(200);
        echo json_encode($array);

    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    } 

} else {
    echo json_encode(
        array("message" => "Data not provided.")
    );
}

?>