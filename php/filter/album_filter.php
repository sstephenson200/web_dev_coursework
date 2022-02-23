<?php 

#checks if array contains item
function check_item_unique ($item, $array) {

    if (in_array($item, $array) and !is_null($item)) {
        return true;
    } else {
        return false;
    }
}

$genre_array = [];
$subgenre_array = [];
$decade_array = [];
$artist_array = [];

if($filtered_data){

} else {
    foreach($album_data as $row) {

        $album_id = $row['album_id'];

        //get genre titles
        $genre_endpoint = $base_url . "album/getGenreByAlbumID.php?album_id=$album_id";
        $genre_resource = file_get_contents($genre_endpoint);
        $genre_data = json_decode($genre_resource, true);

        foreach($genre_data as $genre_row) {
            if(!check_item_unique($genre_row['genre_title'],$genre_array)) {
                $genre_array[] = $genre_row['genre_title'];
            }
        }

    }
}



?>