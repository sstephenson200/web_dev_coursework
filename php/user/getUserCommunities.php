<?php

//get user's favourite and owned albums if logged in
if(isset($_SESSION['userLoggedIn'])){
    $joined_community_endpoint = $base_url . "user/getJoinedCommunitiesByUserID.php?user_id=$logged_in_user_id";
    $joined_community_resource = @file_get_contents($joined_community_endpoint);
    $joined_community_data = json_decode($joined_community_resource, true);

} else {
    $joined_community_data = null;
}

?>