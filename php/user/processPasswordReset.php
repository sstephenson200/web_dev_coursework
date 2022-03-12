<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['submit'])) {

    $email = $_POST['emailReset'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);

    include("passwordResetController.php");

    $password_reset = new PasswordResetController($email);

    $errors = $password_reset -> checkPasswordReset();
    if(!$errors){
        //get user_id for provided email
        $user_endpoint = $base_url . "user/getUserIDByEmail.php?email=$email";
        $user_resource = @file_get_contents($user_endpoint);
        $user_data = json_decode($user_resource, true);

        //check if email is valid
        if($user_data) {
            if(array_key_exists('message', $user_data)) {
                $_SESSION['passwordResetMessage'] = $user_data['message'];
            } else {
                $user_id = $user_data[0]['user_id'];
                //generate new password
                $password = $password_reset -> generateUserPassword();
                //update user password
                $password_endpoint = $base_url . "user/updatePassword.php?password=$password&user_id=$user_id";
                $password_resource = file_get_contents($password_endpoint);
                $password_data = json_decode($password_resource, true);
    
                if($password_data['message'] != "Password updated.") {
                    $_SESSION['passwordResetMessage'] = $password_data['message'];
                } else {
                    //email to user
                    $message = "Your new password is $password. Please update is as soon as possible.";
                    $headers = "From: <passwordReset@pebblerevolution.com>" . "\r\n";
                    //mail($email, "Password Reset", $message, $headers);
                    $_SESSION['passwordResetMessage'] = "Updated.";
                }
            }
        } else {
            $_SESSION['passwordResetMessage'] = "Invalid email.";
        }
        
    } else{
        $_SESSION['passwordResetMessage'] = $errors[0];
    }

    echo "<script>window.location = '../../forgot_password.php'</script>";
    
}

?>