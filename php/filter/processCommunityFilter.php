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
function oneFilterSet($community_filters){

    $flag = false;

    if(!empty($community_filters['artists']) and empty($community_filters['genres']) and empty($community_filters['subgenres'])){
        $flag = true;
    }

    if(empty($community_filters['artists']) and !empty($community_filters['genres']) and empty($community_filters['subgenres'])){
        $flag = true;
    }

    if(empty($community_filters['artists']) and empty($community_filters['genres']) and !empty($community_filters['subgenres'])){
        $flag = true;
    }

    return $flag;

}

//Function to check if community data matches filter options
function checkCommunityFiltering($community, $community_filters) {

    $genre_check = true;
    $subgenre_check = true;

    if(isset($community_filters['artists']) and !empty($community_filters['artists'])){
        if(!in_array($community['artist_name'], $community_filters['artists'])){
            return false;
        }
    }

    if(isset($community_filters['genres']) and !empty($community_filters['genres'])){

        $genres = explode(",", $community['Genres']);

        if(is_array($genres)){
            foreach($genres as $genre){
                if(!in_array($genre, $community_filters['genres'])){
                    $genre_check = false;
                } else {
                    //if one genre for community is in community filters, show community
                    $genre_check = true;
                    break;
                }
            }
        
            if(!$genre_check){
                return false;
            }
        } else {
            if(!in_array($genres, $community_filters['genres'])){
                return false;
            }
        }

    }

    if(isset($community_filters['subgenres']) and !empty($community_filters['subgenres'])){

        $subgenres = explode(",", $community['Subgenres']);

        if(is_array($subgenres)){
            foreach($subgenres as $subgenre){
                if(!in_array($subgenre, $community_filters['subgenres'])){
                    $subgenre_check = false;
                } else {
                    //if one subgenre for community is in community filters, show community
                    $subgenre_check = true;
                    break;
                }
            }
        
            if(!$subgenre_check){
                return false;
            }
        } else {
            if(!in_array($subgenres, $community_filters['subgenres'])){
                return false;
            }
        }

    }

    return true;
}

$community_filters = $_SESSION["community_filters"];

//add artist to community_filters
if(isset($_POST['communityArtistSelector'])){
    $artist = $_POST['communityArtistSelector'];

    if(!isset($community_filters['artists'])) {
        $community_filters['artists'] = [];
    }
    
    if(!check_item_unique($artist,$community_filters['artists'])) {
        if($artist != "Select artist"){
            array_push($community_filters['artists'], $artist);
        }
    }    
}

//add genre to community_filters
if(isset($_POST['communityGenreSelector'])){
    $genre = $_POST['communityGenreSelector'];

    if(!isset($community_filters['genres'])) {
        $community_filters['genres'] = [];
    }
    
    if(!check_item_unique($genre,$community_filters['genres'])) {
        if($genre != "Select genre"){
            array_push($community_filters['genres'], $genre);
        }
    }    
}

//add subgenre to community_filters
if(isset($_POST['communitySubgenreSelector'])){
    $subgenre = $_POST['communitySubgenreSelector'];

    if(!isset($community_filters['subgenres'])) {
        $community_filters['subgenres'] = [];
    }
    
    if(!check_item_unique($subgenre,$community_filters['subgenres'])) {
        if($subgenre != "Select subgenre"){
            array_push($community_filters['subgenres'], $subgenre);
        }
    }    
}

//get community filters
$_SESSION['community_filters'] = $community_filters;
$community_data = $_SESSION["community_data"];

//check if filtered data already exists
if(isset($_SESSION['filtered_community_data'])){
    $filtered_community_data = $_SESSION['filtered_community_data'];
} else {
    $filtered_community_data= [];
}

$single_filter_applied = oneFilterSet($community_filters);

//if filtered data exists, apply filters, else apply to community_data
if(empty($filtered_community_data) or $single_filter_applied or strpos($location, "removeCommunityFilter.php")){
    $array = $community_data;
} else {
    $array = $filtered_community_data;
}

foreach($array as $community) { 

    //if no filters, clear filtered data
    if(empty($community_filters['artists']) and empty($community_filters['genres']) and empty($community_filters['subgenres'])){
        $_SESSION['filtered_community_data'] = [];
        break;
    }

    $flag = checkCommunityFiltering($community, $community_filters);

    if($flag and !check_item_unique($community,$filtered_community_data)){
        array_push($filtered_community_data, $community);
        $_SESSION['filtered_community_data'] = $filtered_community_data;
    } else if(!$flag){
        
        if(($key = array_search($community, $filtered_community_data)) !== false){
            unset($filtered_community_data[$key]);
            $_SESSION['filtered_community_data'] = $filtered_community_data;
        } 
    } 

}

echo '<script>window.location = "../../community_browse.php"</script>';

?>