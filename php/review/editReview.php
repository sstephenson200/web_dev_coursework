<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['edit'])){
    $user_id = $_POST['user_id'];
    $album_id = $_POST['album_id']; 
    $title = urlencode($_POST['reviewTitle']);
    $text = urlencode($_POST['reviewText']);
    $rating = $_POST['reviewRating'];

    //update review
    $edit_endpoint = $base_url . "review/updateReview.php?album_id=$album_id&user_id=$user_id&review_title=$title&review_text=$text&review_rating=$rating";
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
    $_SESSION['postReview'] = "Error.";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>