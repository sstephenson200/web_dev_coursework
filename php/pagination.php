<?php

if(isset($_GET['pageNumber'])){
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 1;
    }

$cardsPerPage = 24;

$offset = ($pageNumber - 1) * $cardsPerPage;

$count_rows = "SELECT COUNT(*) FROM album";
$count_results = $conn -> query($count_rows);
$total_rows = mysqli_fetch_array($count_results)[0];

$totalPages = ceil($total_rows / $cardsPerPage);

$prev_page = $pageNumber - 1;
$next_page = $pageNumber + 1;

?>