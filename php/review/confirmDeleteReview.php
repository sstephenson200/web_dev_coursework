<?php

session_start();

if(isset($_GET['user_id']) and isset($_GET['album_id'])){
    $_SESSION['reviewDetails'] = [$_GET['user_id'],$_GET['album_id']];
}

$_SESSION['postReview'] = "Delete review.";

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>