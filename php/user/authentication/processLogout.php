<?php

//remove cookies
if(isset($_COOKIE['rememberMe'])){
    unset($_COOKIE['rememberMe']);
    setcookie("rememberMe", null, -1, "/");
}

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
} else {
    $user_id = null;
}

if($user_id){
    //delete user token
    $delete_endpoint = $base_url . "user/deleteUser/deleteUserToken.php?user_id=$user_id";
    $delete_resource = file_get_contents($delete_endpoint);
    $delete_data = json_decode($delete_resource, true);
}

session_unset();
session_destroy();

echo "<script>window.location = '../../../index.php'</script>";

?>