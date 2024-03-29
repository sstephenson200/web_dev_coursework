<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../authentication/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_GET['album_id']) and isset($_GET['favourited'])){

    $album_id = $_GET['album_id'];
    $favourited = $_GET['favourited'];

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        $logged_in_user_id = $token_data[0]['user_id'];

        if($favourited){
            //remove album
            $remove_endpoint = $base_url . "user/deleteUser/deleteUserFavourite.php?user_id=$logged_in_user_id&album_id=$album_id";
            $remove_resource = file_get_contents($remove_endpoint);
            $remove_data = json_decode($remove_resource, true);
        } else {
            //add album
            $add_endpoint = $base_url . "user/addUser/addUserFavourite.php?user_id=$logged_in_user_id&album_id=$album_id";
            $add_resource = file_get_contents($add_endpoint);
            $add_data = json_decode($add_resource, true);
        }

    }

}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>