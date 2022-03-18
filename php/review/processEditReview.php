<?php

session_start();

$_SESSION['editReview'] = "Edit";

$album_id = $_GET['album_id'];
$review_title = $_GET['title'];
$text = $_GET['text'];
$review_rating = $_GET['review_rating'];

$_SESSION['editDetails'] = [$album_id, $review_title, $text, $review_rating]; 

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>