<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['saveProfile'])){
    $user_art = urlencode($_POST['updateProfilePic']);
    $location = urlencode($_POST['updateLocation']);
    $bio = urlencode($_POST['updateBio']);

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //update profile data
            $profile_endpoint = $base_url . "user/editUser/updateUserProfile.php?user_id=$logged_in_user_id&art_url=$user_art&location_name=$location&user_bio=$bio";
            $profile_resource = file_get_contents($profile_endpoint);
            $profile_data = json_decode($profile_resource, true);

            if($profile_data){
                $_SESSION['userSettingsMessage'] = $profile_data['message'];
            } else {
                $_SESSION['userSettingsMessage'] = "Error.";
            }

        } else {
            echo "<script>window.location = '../../index.php'</script>";
        }

    } else {
        echo "<script>window.location = '../../index.php'</script>";
    }

} else {
    $_SESSION['userSettingsMessage'] = "Error.";
}

echo "<script>window.location = '../../user_settings.php?user_id=$logged_in_user_id'</script>";

?>