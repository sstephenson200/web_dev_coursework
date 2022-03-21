<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_POST['closeReport'])){

    $report_id = $_POST['report_id'];

    //delete user report
    $close_endpoint = $base_url . "user/deleteUser/closeUserReport.php?report_id=$report_id";
    $close_resource = @file_get_contents($close_endpoint);
    $close_data = json_decode($close_resource, true);

    if($close_data){
        if($close_data['message'] != "User reported deleted."){
            $_SESSION['adminMessage'] = $close_data['message'];
        }
    } else {
        $_SESSION['adminMessage'] = "Error.";
    }

} else if(isset($_POST['banUser'])) {
    $user_id = $_POST['user_id'];

    $_SESSION['adminMessage'] = "Delete account.";
    $_SESSION['banUserDetails'] = $user_id;
    
} else {
    $_SESSION['adminMessage'] = "Error.";
}

echo "<script>window.location = '../../../admin.php'</script>";


?>