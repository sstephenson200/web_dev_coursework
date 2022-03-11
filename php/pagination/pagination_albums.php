<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 24;

$offset = ($pageNumber - 1) * $cardsPerPage;

$total_album_rows = $album_count;
$total_album_pages = ceil($total_album_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

$filtered_data = $_SESSION['filtered_data'];

if(!empty($filtered_data)){
    $visible_album_data = array_slice($filtered_data,$offset,$cardsPerPage);
} else if($album_data) {
    $visible_album_data = array_slice($album_data,$offset,$cardsPerPage);
} else {
    $visible_album_data = null;
}

?>