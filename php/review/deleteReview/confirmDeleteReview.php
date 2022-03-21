<?php

session_start();

if(isset($_SESSION['userLoggedIn']) and isset($_GET['album_id'])){
    $_SESSION['postReview'] = "Delete review.";
    $_SESSION['reviewDetails'] = $_GET['album_id'];
} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>