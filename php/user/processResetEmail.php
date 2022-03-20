<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../user/rememberMeController.php");
$remember = new rememberMeController();

$location = $_SERVER['HTTP_REFERER'];

if(isset($_SESSION['userLoggedIn']) and isset($_POST['confirmEmailReset'])){

    $email = $_POST['email'];
    $password = $_POST['passwordConfirmEmailReset'];
    //get logged in user id
    $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
    $token = $tokens[0];
    $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
    $token_resource = file_get_contents($token_endpoint);
    $token_data = json_decode($token_resource, true);

    if($token_data){
        $logged_in_user_id = $token_data[0]['user_id'];

        //get password for logged in user
        $check_password_endpoint = $base_url . "user/getUser/getUserPasswordByID.php?user_id=$logged_in_user_id";
        $check_password_resource = file_get_contents($check_password_endpoint);
        $check_password_data = json_decode($check_password_resource, true);

        if($check_password_data){
            $hashed_password = $check_password_data[0]['user_password'];
            if(password_verify($password, $hashed_password)) {
                //reset email
                $email_endpoint = $base_url . "user/editUser/updateUserEmail.php?user_id=$logged_in_user_id&email=$email";
                $email_resource = file_get_contents($email_endpoint);
                $email_data = json_decode($email_resource, true);

                if($email_data){
                    $_SESSION['userSettingsMessage'] = $email_data['message'];
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
        $_SESSION['userSettingsMessage'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../index.php'</script>";
}

echo "<script>window.location = '$location'</script>";

?>