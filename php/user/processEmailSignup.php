<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_GET['emailListSignup'])){
    $email = $_GET['emailListSignup'];

    if(trim($email) !== ""){
        $add_email_endpoint = $base_url . "user/createEmailSignup.php?email=$email";
        $add_email_resource = file_get_contents($add_email_endpoint);
        $add_email_data = json_decode($add_email_resource, true);

        $value = $add_email_data['message'];

        $_SESSION['email_submission'] = $value;
    }

}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>