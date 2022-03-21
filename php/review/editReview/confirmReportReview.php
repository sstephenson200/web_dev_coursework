<?php

session_start();

if(isset($_SESSION['userLoggedIn']) and isset($_GET['album_id']) and isset($_GET['user_id'])){
    $_SESSION['postReview'] = "Report review.";
    $_SESSION['reportDetails'] = [$_GET['album_id'], $_GET['user_id']];
} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>