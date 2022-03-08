<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['submit'])) {

    $email = $_POST['emailLogin'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $password = $_POST['passwordLogin'];

    include ("LoginController.php");

    $login = new loginController($email, $password);

    $errors = $login -> checkLogin();
    if(!$errors){
        //get password for provided email
        $login_endpoint = $base_url . "user/getUserPassword.php?emailLogin=$email";
        $login_resource = file_get_contents($login_endpoint);
        $login_data = json_decode($login_resource, true);

        //check if provided email is recognised
        if(array_key_exists('message', $login_data)) {
            $_SESSION['loginErrors'] = $login_data['message'];
        } else {
            //check password at login against stored password
            $hashed_password = $login_data[0]['user_password'];
            $flag = password_verify($password, $hashed_password);
            if(!$flag){
                //log error if password is incorrect
                $_SESSION['loginErrors'] = "Password incorrect.";
            } else {
                //login successful
                $_SESSION['usedID_LoggedIn'] = $login_data[0]['user_id'];;
            }
        }

    } else{
        $_SESSION['loginErrors'] = $errors[0];
    }

    if(isset($_SESSION['loginErrors']) ){
        echo "<script>window.location = '../../login.php'</script>";
    } else {
        echo "<script>window.location = '../../index.php'</script>";
    }
}

?>