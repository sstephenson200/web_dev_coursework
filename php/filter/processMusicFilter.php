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

//Function to check if only one filter has been set
function oneFilterSet($active_filters){

    $flag = false;

    if(!empty($active_filters['artists']) and empty($active_filters['genres']) and empty($active_filters['subgenres']) and empty($active_filters['ratings']) and empty($active_filters['decades'])){
        $flag = true;
    }

    if(empty($active_filters['artists']) and !empty($active_filters['genres']) and empty($active_filters['subgenres']) and empty($active_filters['ratings']) and empty($active_filters['decades'])){
        $flag = true;
    }

    if(empty($active_filters['artists']) and empty($active_filters['genres']) and !empty($active_filters['subgenres']) and empty($active_filters['ratings']) and empty($active_filters['decades'])){
        $flag = true;
    }

    if(empty($active_filters['artists']) and empty($active_filters['genres']) and empty($active_filters['subgenres']) and !empty($active_filters['ratings']) and empty($active_filters['decades'])){
        $flag = true;
    }

    if(empty($active_filters['artists']) and empty($active_filters['genres']) and empty($active_filters['subgenres']) and empty($active_filters['ratings']) and !empty($active_filters['decades'])){
        $flag = true;
    }

    return $flag;

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
        if($artist != "Select artist"){
            array_push($active_filters['artists'], $artist);
        }
    }    
}

//add genre to active_filters
if(isset($_POST['genreSelector'])){
    $genre = $_POST['genreSelector'];

    if(!isset($active_filters['genres'])) {
        $active_filters['genres'] = [];
    }
    
    if(!check_item_unique($genre,$active_filters['genres'])) {
        if($genre != "Select genre"){
            array_push($active_filters['genres'], $genre);
        }
    }    
}

//add subgenre to active_filters
if(isset($_POST['subgenreSelector'])){
    $subgenre = $_POST['subgenreSelector'];

    if(!isset($active_filters['subgenres'])) {
        $active_filters['subgenres'] = [];
    }
    
    if(!check_item_unique($subgenre,$active_filters['subgenres'])) {
        if($subgenre != "Select subgenre"){
            array_push($active_filters['subgenres'], $subgenre);
        }
    }    
}

//add rating to active_filters
for($i=5; $i>=0; $i--){
    $rating = "rating$i";
    if(isset($_POST[$rating])){
        $rating_value = $_POST[$rating];

        if(!isset($active_filters['ratings'])) {
            $active_filters['ratings'] = [];
        }
        
        if(!check_item_unique($rating_value,$active_filters['ratings'])) {
            array_push($active_filters['ratings'], $rating_value);
        }  
    }
}

//add year to active_filters
if(isset($_POST['decade_count'])){
    for($i=0; $i<=$_POST['decade_count']; $i++){
        $decade = "year$i";
        if(isset($_POST[$decade])){
            $decade_value = $_POST[$decade];
    
            if(!isset($active_filters['decades'])) {
                $active_filters['decades'] = [];
            }
            
            if(!check_item_unique($decade_value,$active_filters['decades'])) {
                array_push($active_filters['decades'], $decade_value);
            }  
        }
    }
}

//get active filters
$_SESSION['active_filters'] = $active_filters;
$album_data = $_SESSION["album_data"];

//check if filtered data already exists
if(isset($_SESSION['filtered_data'])){
    $filtered_data = $_SESSION['filtered_data'];
} else {
    $filtered_data= [];
}

//if filtered data exists, apply filters, else apply to album_data
if(empty($filtered_data) or oneFilterSet($active_filters)){
    $array = $album_data;
} else {
    $array = $filtered_data;
}

foreach($array as $album) { 

    //if no filters, clear filtered data
    if(empty($active_filters['artists']) and empty($active_filters['genres']) and empty($active_filters['subgenres']) and empty($active_filters['ratings']) and empty($active_filters['decades'])){
        $_SESSION['filtered_data'] = [];
        break;
    }

    $flag = checkAlbumFiltering($album, $active_filters);

    if($flag and !check_item_unique($album,$filtered_data)){
        array_push($filtered_data, $album);
        $_SESSION['filtered_data'] = $filtered_data;
    }

}

echo '<script>window.location = "../../album_browse.php"</script>';

?>