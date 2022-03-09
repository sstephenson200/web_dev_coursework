<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['submit'])) {

    $email = $_POST['emailLogin'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $password = $_POST['passwordLogin']; 

    include("loginController.php");
    include("rememberMeController.php");

    $login = new loginController($email, $password);
    $remember = new RememberMeController();

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
                $user_id = $login_data[0]['user_id'];
                $_SESSION['userID_LoggedIn'] = $user_id;
                if(isset($_POST['loginCheckbox'])){
                    //create token
                    [$selector, $validator, $token] = $remember -> generate_token();
                    //delete prior token
                    $delete_endpoint = $base_url . "user/deleteUserToken.php?user_id=$user_id";
                    $delete_resource = file_get_contents($delete_endpoint);
                    $delete_data = json_decode($delete_resource, true);
                    //set expiration
                    $expiry = date('Y-m-d H:i:s', time() + (86400 * 30));
                    $expiry_request = urlencode($expiry);
                    //create new token
                    $create_endpoint = $base_url . "user/createUserToken.php?selector=$selector&validator=$validator&expiry_date=$expiry_request&user_id=$user_id";
                    $create_resource = file_get_contents($create_endpoint);
                    $create_data = json_decode($create_resource, true);

                    if($create_data['message'] == "Token created."){
                        $_SESSION['rememberMe'] = [$token, $expiry];
                    }

                }
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