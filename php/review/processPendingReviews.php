<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['savePendingReviews']) or isset($_POST['saveReportedReviews'])){

    foreach(array_combine($_POST['review_id'], $_POST['pendingReviewStatus']) as $review_id => $status){
        
        if($status == "Approved") {
            //approve review
            $approve_endpoint = $base_url . "review/editReview/approveReview.php?review_id=$review_id";
            $approve_resource = file_get_contents($approve_endpoint);
            $approve_data = json_decode($approve_resource, true);

        } else if ($status == "Rejected") {
            //approve review
            $reject_endpoint = $base_url . "review/editReview/rejectReview.php?review_id=$review_id";
            $reject_resource = file_get_contents($reject_endpoint);
            $reject_data = json_decode($reject_resource, true);

            if($reject_data){
                $_SESSION['adminMessage'] = $reject_data['message'];

                if($reject_data['message'] == "Review rejected."){
                    //delete review
                    $delete_endpoint = $base_url . "review/deleteReview/deleteReviewByID.php?review_id=$review_id";
                    $delete_resource = file_get_contents($delete_endpoint);
                    $delete_data = json_decode($delete_resource, true);

                }

            } else {
                $_SESSION['adminMessage'] = "Error.";
            }
        }

    }

} else {
    $_SESSION['adminMessage'] = "Error.";
}

echo "<script>window.location = '../../admin.php'</script>";

?>