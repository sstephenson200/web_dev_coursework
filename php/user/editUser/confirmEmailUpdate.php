<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_SESSION['userLoggedIn'])){

    if(isset($_POST['changeEmail'])) {
        $email = $_POST['emailReset'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        //check if provided email is valid
        if(trim($email) !== "" and filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = urlencode($email);
            $valid_email_endpoint = $base_url . "user/getUser/getUserIDByEmail.php?email=$email";
            $valid_email_resource = file_get_contents($valid_email_endpoint);
            $valid_email_data = json_decode($valid_email_resource, true);

            if(!array_key_exists('message', $valid_email_data) or $valid_email_data['message'] != "Invalid email value."){
                $_SESSION['userSettingsMessage'] = "Email in use.";
            } else {
                $_SESSION['userSettingsMessage'] = "Reset email.";
                $_SESSION['emailResetDetails'] = $email;
            }

        } else {
            $_SESSION['userSettingsMessage'] = "Invalid email.";
        }

    } else {
        $_SESSION['userSettingsMessage'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>