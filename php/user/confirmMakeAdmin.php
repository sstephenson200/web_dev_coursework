<?php

session_start();

if(isset($_GET['user_id'])){

    $user_id = $_GET['user_id'];

    $_SESSION['userSettingsMessage'] = "Make admin.";
    $_SESSION['adminUserDetails'] = $user_id;

} else {
    $_SESSION['userSettingsMessage'] = "Error.";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>