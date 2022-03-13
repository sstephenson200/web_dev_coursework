<?php

session_start();

$_SESSION['editReview'] = "Edit";

if(isset($_GET['user_id']) and isset($_GET['album_id']) and isset($_GET['title']) and isset($_GET['text']) and isset($_GET['rating'])){
    $user_id = $_GET['user_id'];
    $album_id = $_GET['album_id'];
    $review_title = $_GET['title'];
    $text = $_GET['text'];
    $rating = $_GET['rating'];
}

$_SESSION['editDetails'] = [$user_id, $album_id, $review_title, $text, $rating]; 

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>