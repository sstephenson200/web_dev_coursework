<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 24;

$offset = ($pageNumber - 1) * $cardsPerPage;

$total_search_rows = $album_count;
$total_search_pages = ceil($total_search_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

$filtered_search_data = $_SESSION['filtered_search_data'];

if(!empty($filtered_search_data)){
    $visible_search_data = array_slice($filtered_search_data,$offset,$cardsPerPage);
} else{
    $visible_search_data = array_slice($search_data,$offset,$cardsPerPage);
}

?>