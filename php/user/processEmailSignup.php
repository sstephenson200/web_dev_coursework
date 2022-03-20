<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_GET['emailListSignup'])){
    $email = $_GET['emailListSignup'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(trim($email) !== "" and filter_var($email, FILTER_VALIDATE_EMAIL)){
        $add_email_endpoint = $base_url . "user/addUser/createEmailSignup.php?email=$email";
        $add_email_resource = file_get_contents($add_email_endpoint);
        $add_email_data = json_decode($add_email_resource, true);

        $value = $add_email_data['message'];

        $_SESSION['email_submission'] = $value;
    } else {
        $_SESSION['email_submission'] = "Invalid email.";
    }
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>