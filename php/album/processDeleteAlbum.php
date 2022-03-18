<?php

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

$location = $_SERVER['HTTP_REFERER'];

include("../user/rememberMeController.php");

$remember = new rememberMeController();

if(isset($_POST['confirmDelete'])){
    $album_id = $_POST['album_id'];
    $password = $_POST['passwordConfirmDelete'];

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUserByToken.php?token=$token";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];
    
            //get password for logged in user
            $check_password_endpoint = $base_url . "user/getUserPasswordByID.php?user_id=$logged_in_user_id";
            $check_password_resource = file_get_contents($check_password_endpoint);
            $check_password_data = json_decode($check_password_resource, true);
    
            if($check_password_data){
                $hashed_password = $check_password_data[0]['user_password'];
                if(password_verify($password, $hashed_password)) {
                    
                    //delete songs
                    $songs_endpoint = $base_url . "album/deleteSongsPerAlbum.php?album_id=$album_id";
                    $songs_resource = file_get_contents($songs_endpoint);
                    $songs_data = json_decode($songs_resource, true);

                    if($songs_data['message'] != "Songs deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete genres
                    $genres_endpoint = $base_url . "album/deleteGenresPerAlbum.php?album_id=$album_id";
                    $genres_resource = file_get_contents($genres_endpoint);
                    $genres_data = json_decode($genres_resource, true);

                    if($genres_data['message'] != "Genres deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete subgenres
                    $subgenres_endpoint = $base_url . "album/deleteSubgenresPerAlbum.php?album_id=$album_id";
                    $subgenres_resource = file_get_contents($subgenres_endpoint);
                    $subgenres_data = json_decode($subgenres_resource, true);

                    if($subgenres_data['message'] != "Subgenres deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete favourites
                    $favourite_endpoint = $base_url . "album/deleteFavouriteAlbumsByAlbumID.php?album_id=$album_id";
                    $favourite_resource = file_get_contents($favourite_endpoint);
                    $favourite_data = json_decode($favourite_resource, true);

                    if($favourite_data['message'] != "Favourite deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete owned
                    $owned_endpoint = $base_url . "album/deleteOwnedAlbumsByAlbumID.php?album_id=$album_id";
                    $owned_resource = file_get_contents($owned_endpoint);
                    $owned_data = json_decode($owned_resource, true);

                    if($owned_data['message'] != "Owned deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete reviews
                    $review_endpoint = $base_url . "review/deleteReviewByAlbumID.php?album_id=$album_id";
                    $review_resource = file_get_contents($review_endpoint);
                    $review_data = json_decode($review_resource, true);

                    if($review_data['message'] != "Review deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } 

                    //delete album
                    $album_endpoint = $base_url . "album/deleteAlbum.php?album_id=$album_id";
                    $album_resource = file_get_contents($album_endpoint);
                    $album_data = json_decode($album_resource, true);

                    if($album_data['message'] != "Album deleted."){
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    } else {
                        $_SESSION['albumMessage'] = "Album deleted.";
                    }

                } else {
                    $_SESSION['albumMessage'] = "Incorrect password.";
                    echo "<script>window.location = '$location'</script>";
                }
    
            } else {
                $_SESSION['albumMessage'] = "Error.";
            }

        } else {
            $_SESSION['albumMessage'] = "Error.";
        }
    
    } else {
        echo '<script>window.location = "../../index.php"</script>';
    }   

} else {
    $_SESSION['albumMessage'] = "Error.";
}

echo "<script>window.location = '$location'</script>";

?> 