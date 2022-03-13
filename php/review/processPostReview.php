<?php 

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['submit'])) {

    $album_id = $_POST['album_id'];
    $user_id = $_POST['user_id'];
    $title = urlencode($_POST['reviewTitle']);
    $text = urlencode($_POST['reviewText']);
    $rating = $_POST['reviewRating'];

    //check if user has already posted review
    $previous_review_endpoint = $base_url . "review/checkReviewExists.php?album_id=$album_id&user_id=$user_id";
    $previous_review_resource = file_get_contents($previous_review_endpoint);
    $previous_review_data = json_decode($previous_review_resource, true);

    if($previous_review_data){
        if($previous_review_data['message'] == "No review."){

            //create review
            $review_endpoint = $base_url . "review/createReview.php?album_id=$album_id&user_id=$user_id&reviewTitle=$title&reviewText=$text&reviewRating=$rating";
            $review_resource = file_get_contents($review_endpoint);
            $review_data = json_decode($review_resource, true);

            if($review_data){
                $_SESSION['postReview'] = $review_data['message'];
            } else {
                $_SESSION['postReview'] = "Error.";
            }
                    
        } else {
            $_SESSION['postReview'] = "Previous review.";
        }
    } else {
        $_SESSION['postReview'] = "Error.";
    } 

}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>