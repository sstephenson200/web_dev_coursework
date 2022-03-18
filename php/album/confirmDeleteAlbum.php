<?php

session_start();

if(isset($_SESSION['userLoggedIn'])){
    $_SESSION['albumMessage'] = "Delete Album.";

    if(isset($_GET['album_id'])){
        $album_id = $_GET['album_id'];
        $_SESSION['albumDetails'] = $album_id;
    }
} else {
    echo "<script>window.location = '../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>