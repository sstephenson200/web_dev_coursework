<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("rememberMeController.php");

$remember = new RememberMeController();

if(isset($_POST['changePassword'])) {

    $passwordOld = $_POST['passwordResetOld'];
    $passwordNew1 = $_POST['passwordResetNew1'];
    $passwordNew2 = $_POST['passwordResetNew2'];

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //check two new passwords match
            if($passwordNew1 == $passwordNew2){
                //check old password is correct
                $check_password_endpoint = $base_url . "user/getUserPasswordByID.php?user_id=$logged_in_user_id";
                $check_password_resource = file_get_contents($check_password_endpoint);
                $check_password_data = json_decode($check_password_resource, true);
            
                if($check_password_data){
                    $hashed_password = $check_password_data[0]['user_password'];
                    if(password_verify($passwordOld, $hashed_password)) {
                        //update password
                        $password_endpoint = $base_url . "user/updatePassword.php?password=$passwordNew1&user_id=$logged_in_user_id";
                        $password_resource = file_get_contents($password_endpoint);
                        $password_data = json_decode($password_resource, true);
                        
                        if($password_data['message'] != "Password updated.") {
                            $_SESSION['userSettingsMessage'] = "Error.";
                        } else {
                            $_SESSION['userSettingsMessage'] = $password_data['message'];
                        }
                    
                    } else {
                        $_SESSION['userSettingsMessage'] = "Incorrect password.";
                    }
                } else {
                    $_SESSION['userSettingsMessage'] = "Error.";
                }
            
            } else {
                $_SESSION['userSettingsMessage'] = "Passwords not a match.";
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