<?php

session_start();

if(isset($_SESSION['userLoggedIn']) and isset($_GET['user_id'])){

    if($_GET['reported'] == false) {
        $_SESSION['reportUser'] = "Report user.";
        $_SESSION['reportUserDetails'] = $_GET['user_id'];
    } else {
        $_SESSION['reportUser'] = "Already reported.";
    }

} else {
    echo "<script>window.location = '../../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>