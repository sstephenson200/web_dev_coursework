<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 24;

$offset = ($pageNumber - 1) * $cardsPerPage;

$count_album_rows = "SELECT COUNT(*) FROM album";
$count_album_results = $conn -> query($count_album_rows);
$total_album_rows = mysqli_fetch_array($count_album_results)[0];
$total_album_pages = ceil($total_album_rows / $cardsPerPage);

$count_community_rows = "SELECT COUNT(*) FROM community";
$count_community_results = $conn -> query($count_community_rows);
$total_community_rows = mysqli_fetch_array($count_community_results)[0];
$total_community_pages = ceil($total_community_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

?>