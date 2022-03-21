<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../../user/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['report'])){
    $album_id = $_POST['album_id'];
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

            //get review_id
            $review_endpoint = $base_url . "review/getReview/checkReviewExists.php?album_id=$album_id&user_id=$user_id";
            $review_resource = file_get_contents($review_endpoint);
            $review_data = json_decode($review_resource, true);

            if($review_data){

                $review_id = $review_data[0]['review_id'];

                //report review
                $report_endpoint = $base_url . "review/editReview/reportReview.php?review_id=$review_id";
                $report_resource = file_get_contents($report_endpoint);
                $report_data = json_decode($report_resource, true);

                if($report_data['message']){
                    $_SESSION['postReview'] = $report_data['message'];
                } else {
                    $_SESSION['postReview'] = "Error.";
                }

            } else {
                $_SESSION['postReview'] = "Error.";
            }            

        } else {
            echo "<script>window.location = '../../../index.php'</script>";
        }    

    } else {
        $_SESSION['postReview'] = "Error.";
    }

} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?> 