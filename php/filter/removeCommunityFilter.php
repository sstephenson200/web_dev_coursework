<?php

session_start();

$community_filters = $_SESSION["community_filters"];


//remove artist filters
if(isset($_GET['artist'])){
    $artist = $_GET['artist'];
}

if($community_filters['artists']){

    if (in_array($artist, $community_filters['artists'])) {

        foreach($community_filters['artists'] as $key => $applied_artists){

            if($applied_artists == $artist) {
                unset($community_filters['artists'][$key]);
                $_SESSION['community_filters'] = $community_filters;
            }
            
        }
        
    }
}

//remove genre filters
if(isset($_GET['genre'])){
    $genre = $_GET['genre'];
}

if($community_filters['genres']){

    if (in_array($genre, $community_filters['genres'])) {

        foreach($community_filters['genres'] as $key => $applied_genres){
    
            if($applied_genres == $genre) {
                unset($community_filters['genres'][$key]);
                $_SESSION['community_filters'] = $community_filters;
            }
            
        }
        
    }
}

//remove subgenre filters
if(isset($_GET['subgenre'])){
    $subgenre = $_GET['subgenre'];
}

if($community_filters['subgenres']){

    if (in_array($subgenre, $community_filters['subgenres'])) {

        foreach($community_filters['subgenres'] as $key => $applied_subgenres){
    
            if($applied_subgenres == $subgenre) {
                unset($community_filters['subgenres'][$key]);
                $_SESSION['community_filters'] = $community_filters;
            }
            
        }
        
    }
}

echo '<script>window.location = "processCommunityFilter.php"</script>';

?>