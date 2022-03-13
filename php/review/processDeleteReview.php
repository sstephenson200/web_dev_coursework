<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['delete'])){
    $album_id = $_POST['album_id'];
    $user_id = $_POST['user_id'];

    //delete review
    $delete_endpoint = $base_url . "review/deleteReview.php?album_id=$album_id&user_id=$user_id";
    $delete_resource = file_get_contents($delete_endpoint);
    $delete_data = json_decode($delete_resource, true);

    if($delete_data){
        $_SESSION['postReview'] = $delete_data['message'];
    } else {
        $_SESSION['postReview'] = "Error.";
    }
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?> 