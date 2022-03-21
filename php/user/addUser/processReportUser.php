<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../authentication/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['confirmReport'])){
    $report_reason = urlencode($_POST['reportReason']);
    $user_id = $_POST['user_id'];
    
    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //report user
            $report_endpoint = $base_url . "user/addUser/reportUser.php?reporter=$logged_in_user_id&reportee=$user_id&reason=$report_reason";
            $report_resource = file_get_contents($report_endpoint);
            $report_data = json_decode($report_resource, true);

            if($report_data['message']){
                $_SESSION['reportUser'] = $report_data['message'];
            }

        } else {
            echo "<script>window.location = '../../../index.php'</script>";
        }    

    } else {
        $_SESSION['reportUser'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?> 