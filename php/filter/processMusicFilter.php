<?php

session_start();

#checks if array contains item
function check_item_unique ($item, $array) {

    if (in_array($item, $array) and !is_null($item)) {
        return true;
    } else {
        return false;
    }
}

//Function to check if album data matches filter options
function checkAlbumFiltering($album, $active_filters) {

    $flag = true;

    if(isset($active_filters['artists'])){
        if(!in_array($album['artist_name'], $active_filters['artists'])){
            $flag = false;
        }
    }

    return $flag;
}

$active_filters = $_SESSION["active_filters"];

//add artist to active_filters
if(isset($_POST['artistSelector'])){
    $artist = $_POST['artistSelector'];

    if(!isset($active_filters['artists'])) {
        $active_filters['artists'] = [];
    }
    
    if(!check_item_unique($artist,$active_filters['artists'])) {
        array_push($active_filters['artists'], $artist);
    }    
}

$_SESSION['active_filters'] = $active_filters;
$album_data = $_SESSION["album_data"];
$filtered_data= [];

foreach($album_data as $album) { 

    if(empty($active_filters['artists'])){
        $_SESSION['filtered_data'] = [];
        break;
    }

    $flag = checkAlbumFiltering($album, $active_filters);

    if($flag){
        array_push($filtered_data, $album);
        $_SESSION['filtered_data'] = $filtered_data;
    }

}

echo '<script>window.location = "../../album_browse.php"</script>';

?>