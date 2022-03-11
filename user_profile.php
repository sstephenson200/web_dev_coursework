<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    //Card count variables
    $music_card_count = 0;
    $community_card_count = 0;
    $review_card_count = 0;

    $user_id = $_GET['user_id'];

    //get user profile data
    $profile_endpoint = $base_url . "user/getProfileDataByUserID.php?user_id=$user_id";
    $profile_resource = file_get_contents($profile_endpoint);
    $profile_data = json_decode($profile_resource, true);

    $username = $profile_data[0]['user_name'];
    $user_art = $profile_data[0]['art_url'];
    $user_bio = $profile_data[0]['user_bio'];
    $user_location = $profile_data[0]['location_code']; 

    //get owned music
    $owned_endpoint = $base_url . "user/getOwnedAlbumsByUserID.php?user_id=$user_id";
    $owned_resource = @file_get_contents($owned_endpoint);
    $owned_data = json_decode($owned_resource, true);

    //get favourited music
    $favourited_endpoint = $base_url . "user/getFavouriteAlbumsByUserID.php?user_id=$user_id";
    $favourited_resource = @file_get_contents($favourited_endpoint);
    $favourited_data = json_decode($favourited_resource, true);

    //get joined communities
    $community_endpoint = $base_url . "user/getJoinedCommunitiesByUserID.php?user_id=$user_id";
    $community_resource = @file_get_contents($community_endpoint);
    $community_data = json_decode($community_resource, true);

    //get user reviews
    $review_endpoint = $base_url . "review/getReviewsByUserID.php?user_id=$user_id";
    $review_resource = @file_get_contents($review_endpoint);
    $review_data = json_decode($review_resource, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.2/umd/popper.min.js"
        integrity="sha512-aDciVjp+txtxTJWsp8aRwttA0vR2sJMk/73ZT7ExuEHv7I5E6iyyobpFOlEFkq59mWW8ToYGuVZFnwhwIUisKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">
    </script>
    <link rel="stylesheet" href="css/ui.css">

</head>

<body>

    <?php
        if(isset($_SESSION['email_submission'])){
            include("includes/modal/emailSignupModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-5 col-md-4 userSidebar">
                <div class="row d-flex justify-content-center mb-3">
                    <div class="col-10 align-self-center">
                        <img src="<?php echo $user_art ?>" class="rounded-circle profilePic"/>
                    </div>
                </div>
                <div class="row d-flex justify-content-center text-center mb-2">
                    <div class="col-12 col-lg-3">
                        <h3><?php echo $username ?></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <h3><?php echo $user_location?></h3>
                    </div>
                </div>
                <div class="row text-center mb-2">
                    <p><?php echo $user_bio ?></p>
                </div>
                <div class="row text-center mb-2">
                    <div class="col">
                        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username == $username) {?>
                            <a type='button' class='btn styled_button' href='user_settings.php?user_id=<?php echo $user_id ?>'><i class="fas fa-cog"></i> Settings</a>
                        <?php } ?>
                        <?php 
                        if(($AdminCount != 0) and $logged_in_username == $username) { ?>
                            <a type='button' class='btn styled_button' href='admin.php?'><i class="fas fa-tools"></i> Admin</a>
                        <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-sm-7 col-md-8">
                <div class="row py-1">
                    <div class="col-3 offset-9 col-md-1 offset-md-11">
                        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) {?>
                            <a role='button px-1'>
                                <i id='reportIcon' class='far fa-flag fa-lg report' data-toggle='popover' title='Report' data-content='Report Content' data-target='reportIcon'></i>
                            </a>
                        <?php } ?>
                        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) {
                            if($AdminCount != 0) { ?>
                                <a role='button px-1'>
                                    <i id='banIcon' class='fas fa-ban fa-lg ban' data-toggle='popover' title='Ban' data-content='Ban User' data-target='banIcon'></i>
                                </a>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col mx-2">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link profileTabs active" href="#userOwned" data-bs-toggle="tab">Owned Music</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userFavourite" data-bs-toggle="tab">Favourite Music</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userCommunities" data-bs-toggle="tab">Communities</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userReviews" data-bs-toggle="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userPosts" data-bs-toggle="tab">Posts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userComments" data-bs-toggle="tab">Comments</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="userOwned">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php
                                        if($owned_data){
                                            foreach($owned_data as $owned_album){
                                                $album_art_url = $owned_album['art_url'];
                                                $rating = $owned_album['AverageRating'];
                                                $album_title = $owned_album['album_title'];
                                                $album_artist = $owned_album['artist_name'];
                                                $album_id = $owned_album['album_id'];
    
                                                include("includes/music_card.php");
                                                $music_card_count++;
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userFavourite">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php
                                        if($favourited_data){
                                            foreach($favourited_data as $favourited_album){
                                                $album_art_url = $favourited_album['art_url'];
                                                $rating = $favourited_album['AverageRating'];
                                                $album_title = $favourited_album['album_title'];
                                                $album_artist = $favourited_album['artist_name'];
                                                $album_id = $favourited_album['album_id'];
    
                                                include("includes/music_card.php");
                                                $music_card_count++;
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userCommunities">
                            <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php
                                        if($community_data){
                                            foreach($community_data as $joined_community){
                                                $community_id = $joined_community['community_id'];
                                                $community_art_url = $joined_community['art_url'];
                                                $community_name = $joined_community['community_name'];
                                                $community_description = $joined_community['community_description'];
    
                                                //get community size
                                                $community_size_endpoint = $base_url . "community/getCommunitySizeByCommunityID.php?community_id=$community_id";
                                                $community_size_resource = file_get_contents($community_size_endpoint);
                                                $community_size_data = json_decode($community_size_resource, true);
    
                                                $community_members = $community_size_data[0]['MemberCount'];
    
                                                include("includes/community_card.php");
                                                $community_card_count++;
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userReviews">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php
                                        if($review_data){
                                            foreach($review_data as $review){
                                                $album_title = $review['album_title'];
                                                $album_id = $review['album_id'];
                                                $artist_name = $review['artist_name'];
                                                $review_title = $review['review_title'];
                                                $review_body = $review['review_text'];
                                                $review_rating = $review['review_rating'];
                                                $review_date = $review['review_date'];
                                                $username = $review['user_name'];
                                                $user_art = $review['art_url'];
                                                $user_id = $review['user_id'];
    
                                                echo "<div class='row d-flex justify-content-center mx-2'>
                                                        <div class='row text-center'>
                                                            <div class='col-12 col-sm-6'>
                                                                <h6>Album: $album_title</h6>
                                                            </div>
                                                            <div class='col-12 col-sm-6'>
                                                                <h6>Artist: $artist_name</h6>
                                                            </div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col text-center mb-2'>
                                                                <a href='album.php?album_id=$album_id' class='btn styled_button'>View</a>
                                                            </div>
                                                        </div>
                                                    </div>";
                                
                                                echo "<div class='row d-flex justify-content-center'>";
                                                echo "<div class='col-10 col-md-9 mx-4 mb-3'>";
                                                include("includes/review.php");
                                                echo "</div>";
                                                echo "</div>";
                                                $review_card_count++;
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade show" id="userPosts">
                                <h5>User's posts</h5>
                            </div>
                            <div class="tab-pane fade show" id="userComments">
                                <h5>User's comments</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php
            include("includes/footer.php");
        ?>

    </div>

</body>

<?php 
include("js/card_functions.php");
?>

</html>