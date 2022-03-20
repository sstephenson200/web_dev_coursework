<?php

//Check if filter is active
function checkFiltersApplied(){

    if(isset($_SESSION['community_filters'])){

        if(!empty($_SESSION['community_filters']['artists'])){
            return true;
        } else if(!empty($_SESSION['community_filters']['genres'])){
            return true;
        } else if(!empty($_SESSION['community_filters']['subgenres'])){
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

$total_community_rows = $community_count;
$total_community_pages = ceil($total_community_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

$filtered_community_data = $_SESSION['filtered_community_data'];

 if(empty($filtered_community_data) and checkFiltersApplied()){
     $visible_community_data = array_slice($filtered_community_data,$offset,$cardsPerPage);
} else if(!empty($filtered_community_data)){
    $visible_community_data = array_slice($filtered_community_data,$offset,$cardsPerPage);
} else if($community_data) {
    $visible_community_data = array_slice($community_data,$offset,$cardsPerPage);
} else {
    $visible_community_data = null;
}

?>