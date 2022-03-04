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

//Function to check if community data matches filter options
function checkCommunityFiltering($community, $community_filters) {

    $flag = true;
    $artist = $community['artist_name'];

    if(isset($community_filters['artists']) and $artist){
        if(!in_array($community['artist_name'], $community_filters['artists'])){
            $flag = false;
        }
    }

    return $flag;
}

$community_filters = $_SESSION["community_filters"];

//add artist to active_filters
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

$_SESSION['community_filters'] = $community_filters;
$community_data = $_SESSION["community_data"];
$filtered_community_data= [];

foreach($community_data as $community) { 

    if(empty($community_filters['artists']) and empty($community_filters['genres']) and empty($community_filters['subgenres'])){
        $_SESSION['$filtered_community_data'] = [];
        break;
    }

    $flag = checkCommunityFiltering($community, $community_filters);

    if($flag){
        array_push($filtered_community_data, $community);
        $_SESSION['$filtered_community_data'] = $filtered_community_data;
    }

}

echo '<script>window.location = "../../community_browse.php"</script>';

?>