<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 10;

$offset = ($pageNumber - 1) * $cardsPerPage;

$count_review_rows = "SELECT COUNT(*) FROM review WHERE review.album_id=$album_id";
$count_review_results = $conn -> query($count_review_rows);
$total_review_rows = mysqli_fetch_array($count_review_results)[0];
$total_review_pages = ceil($total_review_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

?>