<?php

session_start();

$active_filters = $_SESSION["active_filters"];


//remove artist filters
if(isset($_GET['artist'])){
    $artist = $_GET['artist'];
}

if($active_filters['artists']){

    if (in_array($artist, $active_filters['artists'])) {

        foreach($active_filters['artists'] as $key => $applied_artists){
    
            if($applied_artists == $artist) {
                unset($active_filters['artists'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

//remove genre filters
if(isset($_GET['genre'])){
    $genre = $_GET['genre'];
}

if($active_filters['genres']){

    if (in_array($genre, $active_filters['genres'])) {

        foreach($active_filters['genres'] as $key => $applied_genres){
    
            if($applied_genres == $genre) {
                unset($active_filters['genres'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

//remove subgenre filters
if(isset($_GET['subgenre'])){
    $genre = $_GET['subgenre'];
}

if($active_filters['subgenres']){

    if (in_array($subgenre, $active_filters['subgenres'])) {

        foreach($active_filters['subgenres'] as $key => $applied_subgenres){
    
            if($applied_subgenres == $subgenre) {
                unset($active_filters['subgenres'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

//remove ratings filters
if(isset($_GET['rating'])){
    $rating = $_GET['rating'];
}

if($active_filters['ratings']){

    if (in_array($rating, $active_filters['ratings'])) {

        foreach($active_filters['ratings'] as $key => $applied_ratings){
    
            if($applied_ratings == $rating) {
                unset($active_filters['ratings'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

//remove ratings filters
if(isset($_GET['decade'])){
    $decade = $_GET['decade'];
}

if($active_filters['decades']){

    if (in_array($decade, $active_filters['decades'])) {

        foreach($active_filters['decades'] as $key => $applied_decades){
    
            if($applied_decades == $decade) {
                unset($active_filters['decades'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

echo '<script>window.location = "processMusicFilter.php"</script>';

?>