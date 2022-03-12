<?php

//get user's favourite and owned albums if logged in
if(isset($_SESSION['userLoggedIn'])){
    $favourite_endpoint = $base_url . "user/getFavouriteAlbumsByUserID.php?user_id=$logged_in_user_id";
    $favourite_resource = @file_get_contents($favourite_endpoint);
    $favourite_data = json_decode($favourite_resource, true);

    $owned_endpoint = $base_url . "user/getOwnedAlbumsByUserID.php?user_id=$logged_in_user_id";
    $owned_resource = @file_get_contents($owned_endpoint);
    $owned_data = json_decode($owned_resource, true);
} else {
    $favourite_data = null;
    $owned_data = null;
}

?>