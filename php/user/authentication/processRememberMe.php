<?php

$base_url = "http://localhost/web_dev_coursework/api/";

include("rememberMeController.php");

$remember = new rememberMeController();

if(isset($_COOKIE['rememberMe']) and !isset($_SESSION['userLoggedIn'])) {

    $token = filter_input(INPUT_COOKIE, 'rememberMe', FILTER_SANITIZE_STRING);
    $tokens = $remember -> parse_token($token);

    if($token and $remember -> check_token_valid($tokens[0], $tokens[1])){
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$tokens[0]";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $_SESSION['userLoggedIn'] = $token;
        }
    }

}

?>