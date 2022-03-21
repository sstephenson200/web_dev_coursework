<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../../user/authentication/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['delete'])){
    $album_id = $_POST['album_id'];
    
    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //delete review
            $delete_endpoint = $base_url . "review/deleteReview/deleteReview.php?album_id=$album_id&user_id=$logged_in_user_id";
            $delete_resource = file_get_contents($delete_endpoint);
            $delete_data = json_decode($delete_resource, true);

            if($delete_data){
                $_SESSION['postReview'] = $delete_data['message'];
            } else {
                $_SESSION['postReview'] = "Error.";
            }
        } else {
            echo "<script>window.location = '../../../index.php'</script>";
        }    

    } else {
        $_SESSION['postReview'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?> 