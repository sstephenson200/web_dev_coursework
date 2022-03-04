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

    if(isset($search_filters['artists'])){
        if(!in_array($album['artist_name'], $search_filters['artists'])){
            $flag = false;
        }
    }

    return $flag;
}

$search_filters = $_SESSION["search_filters"];

//add artist to search_filters
if(isset($_POST['searchArtistSelector'])){
    $artist = $_POST['searchArtistSelector'];

    if(!isset($search_filters['artists'])) {
        $search_filters['artists'] = [];
    }
    
    if(!check_item_unique($artist,$search_filters['artists'])) {
        if($artist != "Select artist"){
            array_push($search_filters['artists'], $artist);
        }
    }    
}

$_SESSION['search_filters'] = $search_filters;
$search_data = $_SESSION["search_data"];
$filtered_search_data= [];

foreach($search_data as $album) { 

    if(empty($search_filters['artists']) and empty($search_filters['genres']) and empty($search_filters['subgenres']) and empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $_SESSION['filtered_search_data'] = [];
        break;
    }

    $flag = checkAlbumFiltering($album, $search_filters);

    if($flag){
        array_push($filtered_search_data, $album);
        $_SESSION['filtered_search_data'] = $filtered_search_data;
    }

}

echo '<script>window.location = "../../search.php"</script>';

?>