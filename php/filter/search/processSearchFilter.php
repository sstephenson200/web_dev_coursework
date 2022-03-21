<?php

session_start();
$location = $_SERVER['HTTP_REFERER'];

#checks if array contains item
function check_item_unique ($item, $array) {

    if (in_array($item, $array) and !is_null($item)) {
        return true;
    } else {
        return false;
    }
}

//Function to check if only one filter has been set
function oneFilterSet($search_filters){

    $flag = false;

    if(!empty($search_filters['artists']) and empty($search_filters['genres']) and empty($search_filters['subgenres']) and empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $flag = true;
    }

    if(empty($search_filters['artists']) and !empty($search_filters['genres']) and empty($search_filters['subgenres']) and empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $flag = true;
    }

    if(empty($search_filters['artists']) and empty($search_filters['genres']) and !empty($search_filters['subgenres']) and empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $flag = true;
    }

    if(empty($search_filters['artists']) and empty($search_filters['genres']) and empty($search_filters['subgenres']) and !empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $flag = true;
    }

    if(empty($search_filters['artists']) and empty($search_filters['genres']) and empty($search_filters['subgenres']) and empty($search_filters['ratings']) and !empty($search_filters['decades'])){
        $flag = true;
    }

    return $flag;

}

//Function to check if album data matches filter options
function checkAlbumFiltering($album, $search_filters) {

    $genre_check = true;
    $subgenre_check = true;

    if(isset($search_filters['artists']) and !empty($search_filters['artists'])){
        if(!in_array($album['artist_name'], $search_filters['artists'])){
            return false;
        }
    }

    if(isset($search_filters['genres']) and !empty($search_filters['genres'])){

        $genres = explode(",", $album['Genres']);

        if(is_array($genres)){
            foreach($genres as $genre){
                if(!in_array($genre, $search_filters['genres'])){
                    $genre_check = false;
                } else {
                    //if one genre for album is in search_filters, show album
                    $genre_check = true;
                    break;
                }
            }
        } else {
            if(!in_array($genres, $search_filters['genres'])){
                $genre_check = false;
            }
        }

        if(!$genre_check){
            return false;
        }
        
    }

    if(isset($search_filters['subgenres']) and !empty($search_filters['subgenres'])){

        $subgenres = explode(",", $album['Subgenres']);

        if(is_array($subgenres)){
            foreach($subgenres as $subgenre){
                if(!in_array($subgenre, $search_filters['subgenres'])){
                    $subgenre_check = false;
                } else {
                    //if one genre for album is in search_filters, show album
                    $subgenre_check = true;
                    break;
                }
            }
        } else {
            if(!in_array($subgenres, $search_filters['genres'])){
                $subgenre_check = false;
            }
        }

        if(!$subgenre_check){
            return false;
        }
        
    }

    if(isset($search_filters['ratings']) and !empty($search_filters['ratings'])){
        $album_rating = $album['AverageRating'];
        $album_rating = floor($album_rating);

        if(!in_array($album_rating, $search_filters['ratings'])){
            return false;
        }
    }

    if(isset($search_filters['decades']) and !empty($search_filters['decades'])){
        $year = $album['year_value'];
        $decade = (floor($year/10)*10);
        
        if(!in_array($decade, $search_filters['decades'])){
            return false;
        }
    }

    return true;
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

//add genre to search_filters
if(isset($_POST['searchGenreSelector'])){
    $genre = $_POST['searchGenreSelector'];

    if(!isset($search_filters['genres'])) {
        $search_filters['genres'] = [];
    }
    
    if(!check_item_unique($genre,$search_filters['genres'])) {
        if($genre != "Select genre"){
            array_push($search_filters['genres'], $genre);
        }
    }    
}

//add subgenre to search_filters
if(isset($_POST['searchSubgenreSelector'])){
    $subgenre = $_POST['searchSubgenreSelector'];

    if(!isset($search_filters['subgenres'])) {
        $search_filters['subgenres'] = [];
    }
    
    if(!check_item_unique($subgenre,$search_filters['subgenres'])) {
        if($subgenre != "Select subgenre"){
            array_push($search_filters['subgenres'], $subgenre);
        }
    }    
}

//add rating to search_filters
for($i=5; $i>=0; $i--){
    $rating = "rating$i";
    if(isset($_POST[$rating])){
        $rating_value = $_POST[$rating];

        if(!isset($search_filters['ratings'])) {
            $search_filters['ratings'] = [];
        }
        
        if(!check_item_unique($rating_value,$search_filters['ratings'])) {
            array_push($search_filters['ratings'], $rating_value);
        }  
    }
}

//add year to search_filters
if(isset($_POST['decade_count'])){
    for($i=0; $i<=$_POST['decade_count']; $i++){
        $decade = "year$i";
        if(isset($_POST[$decade])){
            $decade_value = $_POST[$decade];
    
            if(!isset($search_filters['decades'])) {
                $search_filters['decades'] = [];
            }
            
            if(!check_item_unique($decade_value,$search_filters['decades'])) {
                array_push($search_filters['decades'], $decade_value);
            }  
        }
    }
}

//get active search filters
$_SESSION['search_filters'] = $search_filters;
$search_data = $_SESSION["search_data"];

//check if filtered data already exists
if(isset($_SESSION['filtered_search_data'])){
    $filtered_search_data = $_SESSION['filtered_search_data'];
} else {
    $filtered_search_data= [];
}

$single_filter_applied = oneFilterSet($search_filters);

//if filtered data exists, apply filters, else apply to search_data
if(empty($filtered_search_data) or $single_filter_applied or strpos($location, "removeSearchFilter.php")){
    $array = $search_data;
} else {
    $array = $filtered_search_data;
}

foreach($array as $album) { 

    if(empty($search_filters['artists']) and empty($search_filters['genres']) and empty($search_filters['subgenres']) and empty($search_filters['ratings']) and empty($search_filters['decades'])){
        $_SESSION['filtered_search_data'] = [];
        break;
    }

    $flag = checkAlbumFiltering($album, $search_filters);

    if($flag and !check_item_unique($album,$filtered_search_data)){
        array_push($filtered_search_data, $album);
        $_SESSION['filtered_search_data'] = $filtered_search_data;
    } else if(!$flag){
        
        if(($key = array_search($album, $filtered_search_data)) !== false){
            unset($filtered_search_data[$key]);
            $_SESSION['filtered_search_data'] = $filtered_search_data;
        } 
    }

}

echo '<script>window.location = "../../../search.php"</script>';

?>