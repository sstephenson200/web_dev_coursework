<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

$location = $_SERVER['HTTP_REFERER'];

if(isset($_SESSION['userLoggedIn'])){

    if(isset($_POST['changeUsername'])) {
        $username = $_POST['usernameReset'];

        //check if provided username is valid
        if(strlen($username)>4 and strlen($username)<31){
            $valid_username_endpoint = $base_url . "user/getUserIDByUsername.php?username=$username";
            $valid_username_resource = file_get_contents($valid_username_endpoint);
            $valid_username_data = json_decode($valid_username_resource, true);

            if(!array_key_exists('message', $valid_username_data) or $valid_username_data['message'] != "Invalid username value."){
                $_SESSION['userSettingsMessage'] = "Username in use.";
            } else {
                $_SESSION['userSettingsMessage'] = "Reset username.";
                $_SESSION['usernameResetDetails'] = $username;
            }

        } else {
            $_SESSION['userSettingsMessage'] = "Username length.";
        }

    } else {
        $_SESSION['userSettingsMessage'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../index.php'</script>";
}

echo "<script>window.location = '$location'</script>";

?>