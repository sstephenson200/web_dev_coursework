<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 10;

$offset = ($pageNumber - 1) * $cardsPerPage;

if($reviews_data){
    $total_reviews = count($reviews_data); 
} else {
    $total_reviews = 0;
}

$total_review_pages = ceil($total_reviews / $cardsPerPage);

if($total_review_pages>1) {
    $visible_reviews = array_slice($reviews_data,$offset,$cardsPerPage);
} else {
    $visible_reviews = $reviews_data;
}

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

?>