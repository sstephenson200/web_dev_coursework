<?php
session_start();

$base_url = "http://localhost/web_dev_coursework/api/";

if(isset($_POST['submit'])) {

    $email = $_POST['emailSignup'];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $username = $_POST['usernameSignup'];
    $password1 = $_POST['password1Signup'];
    $password2 = $_POST['password2Signup'];

    $_SESSION['emailSignup'] = $email;
    $_SESSION['usernameSignup'] = $username;
    $_SESSION['password1Signup'] = $password1;
    $_SESSION['password2Signup'] = $password2;

    include ("signupController.php");
    include("rememberMeController.php");

    $signup = new signupController($email, $username, $password1, $password2);
    $remember = new rememberMeController();

    $errors = $signup -> checkSignUp();
    if(!$errors){
        //create account
        $signup_endpoint = $base_url . "user/addUser/createAccount.php";

        $opts = array('http' => array('header'=> 'Cookie: ' . $_SERVER['HTTP_COOKIE']."\r\n"));
        $context = stream_context_create($opts);
        session_write_close(); // unlock the file
        $signup_resource = file_get_contents($signup_endpoint, false, $context);
        session_start();
        $signup_data = json_decode($signup_resource, true);

        if($signup_data['message'] != "Account created.") {
            $_SESSION['signupErrors'] = $signup_data['message'];
        } else {
            //signup successful
            $user_id_endpoint = $base_url . "user/getUser/getUserPassword.php?emailLogin=$email";
            $user_id_resource = file_get_contents($user_id_endpoint);
            $user_id_data = json_decode($user_id_resource, true);
            $user_id = $user_id_data[0]['user_id'];

            //create token
            [$selector, $validator, $token] = $remember -> generate_token();
            //set expiration
            $expiry = date('Y-m-d H:i:s', time() + (86400 * 30));
            $expiry_request = urlencode($expiry);
            //create new token
            $create_endpoint = $base_url . "user/addUser/createUserToken.php?selector=$selector&validator=$validator&expiry_date=$expiry_request&user_id=$user_id";
            $create_resource = file_get_contents($create_endpoint);
            $create_data = json_decode($create_resource, true);

            if($create_data['message'] == "Token created."){
                $_SESSION['userLoggedIn'] = $token;
            }
        }

    } else{
        $_SESSION['signupErrors'] = $errors[0];
    }

    unset($_SESSION['emailSignup']);
    unset($_SESSION['usernameSignup']);
    unset($_SESSION['password1Signup']);
    unset($_SESSION['password2Signup']);

    if(isset($_SESSION['signupErrors']) ){
        echo "<script>window.location = '../../../signup.php'</script>";
    } else {
        echo "<script>window.location = '../../../index.php'</script>";
    }
}

?>