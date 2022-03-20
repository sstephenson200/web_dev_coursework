<?php

session_start();

$search_filters = $_SESSION["search_filters"];


//remove artist filters
if(isset($_GET['artist'])){
    $artist = $_GET['artist'];

    if($search_filters['artists']){

        if (in_array($artist, $search_filters['artists'])) {
    
            foreach($search_filters['artists'] as $key => $applied_artists){
    
                if($applied_artists == $artist) {
                    unset($search_filters['artists'][$key]);
                    $_SESSION['search_filters'] = $search_filters;
                }
                
            }
            
        }
    }
}



//remove genre filters
if(isset($_GET['genre'])){
    $genre = $_GET['genre'];

    if($search_filters['genres']){

        if (in_array($genre, $search_filters['genres'])) {
    
            foreach($search_filters['genres'] as $key => $applied_genres){
        
                if($applied_genres == $genre) {
                    unset($search_filters['genres'][$key]);
                    $_SESSION['search_filters'] = $search_filters;
                }
                
            }
            
        }
    }
}

//remove subgenre filters
if(isset($_GET['subgenre'])){
    $subgenre = $_GET['subgenre'];

    if($search_filters['subgenres']){

        if (in_array($subgenre, $search_filters['subgenres'])) {
    
            foreach($search_filters['subgenres'] as $key => $applied_subgenres){
        
                if($applied_subgenres == $subgenre) {
                    unset($search_filters['subgenres'][$key]);
                    $_SESSION['search_filters'] = $search_filters;
                }
                
            }
            
        }
    }
}



//remove ratings filters
if(isset($_GET['rating'])){
    $rating = $_GET['rating'];

    if($search_filters['ratings']){

        if (in_array($rating, $search_filters['ratings'])) {
    
            foreach($search_filters['ratings'] as $key => $applied_ratings){
        
                if($applied_ratings == $rating) {
                    unset($search_filters['ratings'][$key]);
                    $_SESSION['search_filters'] = $search_filters;
                }
                
            }
            
        }
    }
}


//remove decades filters
if(isset($_GET['decade'])){
    $decade = $_GET['decade'];

    if($search_filters['decades']){

        if (in_array($decade, $search_filters['decades'])) {
    
            foreach($search_filters['decades'] as $key => $applied_decades){
        
                if($applied_decades == $decade) {
                    unset($search_filters['decades'][$key]);
                    $_SESSION['search_filters'] = $search_filters;
                }
                
            }
            
        }
    }
}


echo '<script>window.location = "processSearchFilter.php"</script>';

?>