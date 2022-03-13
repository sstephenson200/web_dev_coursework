<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['updateEmailPreferences'])){
    
    if(isset($_POST['radio'])){
        $contact_permissions = $_POST['radio'];
    } else if(isset($_POST['emailOptOut'])) {
        $contact_permissions = null;
    }

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //update contact permissions
            $contact_endpoint = $base_url . "user/updateUserContactPermissions.php?user_id=$logged_in_user_id&permissions=$contact_permissions";
            $contact_resource = file_get_contents($contact_endpoint);
            $contact_data = json_decode($contact_resource, true);

            if($contact_data){
                $_SESSION['userSettingsMessage'] = $contact_data['message'];
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