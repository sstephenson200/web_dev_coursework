<?php

//Check if filter is active
function checkFiltersApplied(){

    if(isset($_SESSION['search_filters'])){

        if(!empty($_SESSION['search_filters']['artists'])){
            return true;
        } else if(!empty($_SESSION['search_filters']['genres'])){
            return true;
        } else if(!empty($_SESSION['search_filters']['subgenres'])){
            return true;
        } else if(!empty($_SESSION['search_filters']['ratings'])){
            return true;
        } else if(!empty($_SESSION['search_filters']['decades'])){
            return true;
        }
    } 

    return false;

}

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 24;

$offset = ($pageNumber - 1) * $cardsPerPage;

$total_album_rows = $album_count;
$total_search_pages = ceil($total_album_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

$filtered_search_data = $_SESSION['filtered_search_data'];

 if(empty($filtered_search_data) and checkFiltersApplied()){
     $visible_search_data = array_slice($filtered_search_data,$offset,$cardsPerPage);
} else if(!empty($filtered_search_data)){
    $visible_search_data = array_slice($filtered_search_data,$offset,$cardsPerPage);
} else if($search_data) {
    $visible_search_data = array_slice($search_data,$offset,$cardsPerPage);
} else {
    $visible_search_data = null;
}

?>