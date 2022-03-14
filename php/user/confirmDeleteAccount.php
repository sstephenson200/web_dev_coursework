<?php

session_start();

if(isset($_SESSION['userLoggedIn'])){
    $_SESSION['userSettingsMessage'] = "Delete account.";
} else {
    echo "<script>window.location = '../../index.php'</script>";
}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>