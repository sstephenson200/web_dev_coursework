<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../user/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['edit'])){
    $album_id = $_POST['album_id']; 
    $title = urlencode($_POST['reviewTitle']);
    $text = urlencode($_POST['reviewText']);
    $rating = $_POST['reviewRating'];

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //update review
            $edit_endpoint = $base_url . "review/editReview/updateReview.php?album_id=$album_id&user_id=$logged_in_user_id&review_title=$title&review_text=$text&review_rating=$rating";
            $edit_resource = file_get_contents($edit_endpoint);
            $edit_data = json_decode($edit_resource, true);

            if($edit_data){
                if($edit_data['message'] == "Review updated.") {
                    $_SESSION['postReview'] = $edit_data['message'];
                } else {
                    $_SESSION['postReview'] = "Error.";
                }
            }

        } else {
            echo "<script>window.location = '../../index.php'</script>";
        }  

    } else {
        echo "<script>window.location = '../../index.php'</script>";
    }

} else {
    $_SESSION['postReview'] = "Error.";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>