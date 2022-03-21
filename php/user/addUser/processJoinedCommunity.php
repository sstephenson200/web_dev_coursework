<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

include("../authentication/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_GET['community_id']) and isset($_GET['joined'])){

    $community_id = $_GET['community_id'];
    $joined = $_GET['joined'];

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUser/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        $logged_in_user_id = $token_data[0]['user_id'];

        if($joined){
            //leave community
            $leave_endpoint = $base_url . "user/deleteUser/leaveCommunity.php?user_id=$logged_in_user_id&community_id=$community_id";
            $leave_resource = file_get_contents($leave_endpoint);
            $leave_data = json_decode($leave_resource, true);
        } else {
            //join community
            $join_endpoint = $base_url . "user/addUser/joinCommunity.php?user_id=$logged_in_user_id&community_id=$community_id";
            $join_resource = file_get_contents($join_endpoint);
            $join_data = json_decode($join_resource, true);
        }

    }

}

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>