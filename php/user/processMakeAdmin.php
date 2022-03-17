<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../user/rememberMeController.php");
$remember = new rememberMeController();

$location = $_SERVER['HTTP_REFERER'];

if(isset($_SESSION['userLoggedIn']) and isset($_POST['confirmAdmin'])){

    $password = $_POST['passwordConfirmAdmin'];
    $user_id =  $_POST['user_id'];
    //get logged in user id
    $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
    $token = $tokens[0];
    $token_endpoint = $base_url . "user/getUserByToken.php?token=$token";
    $token_resource = file_get_contents($token_endpoint);
    $token_data = json_decode($token_resource, true);

    if($token_data){
        $logged_in_user_id = $token_data[0]['user_id'];

        //get password for logged in user
        $check_password_endpoint = $base_url . "user/getUserPasswordByID.php?user_id=$logged_in_user_id";
        $check_password_resource = file_get_contents($check_password_endpoint);
        $check_password_data = json_decode($check_password_resource, true);

        if($check_password_data){
            $hashed_password = $check_password_data[0]['user_password'];
            if(password_verify($password, $hashed_password)) {
                //give admin access
                $admin_endpoint = $base_url . "user/createAdmin.php?user_id=$user_id";
                $admin_resource = file_get_contents($admin_endpoint);
                $admin_data = json_decode($admin_resource, true);

                if($admin_data){
                    $_SESSION['userSettingsMessage'] = $admin_data['message'];
                } else {
                    $_SESSION['userSettingsMessage'] = "Error.";
                }

                } else {
                    $_SESSION['userSettingsMessage'] = "Error.";
                }

            } else {
                $_SESSION['userSettingsMessage'] = "Incorrect password.";
                echo "<script>window.location = '$location'</script>";
            }
        } else {
            $_SESSION['userSettingsMessage'] = "Error.";
        }

} else {
    echo "<script>window.location = '../../index.php'</script>";
}

echo "<script>window.location = '$location'</script>";

?>