<?php

header("Content-Type: application/json");

include("../../connections/dbconn.php");
include("album_api.php");

$database = new Database();
$db = $database -> getConn();

$albums = new Album($db);

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = null;
}

$result = $albums -> searchAlbums($search);
$result = $result -> get_result();
$album_count = $result -> num_rows;

if($album_count != 0) {
    $array = array();

    while($row = $result -> fetch_assoc()) {
        extract($row);
        $album = array (
            "album_id" => $album_id,
            "album_title" => $album_title,
            "album_rating" => $album_rating,
            "artist_name" => $artist_name,
            "art_url" => $art_url,
            "year_value" => $year_value,
            "AverageRating" => $AverageRating,
            "Genres" => $Genres,
            "Subgenres" => $Subgenres
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

?>