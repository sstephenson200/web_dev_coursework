<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    $valid_user = true;

    //Card count variables
    $music_card_count = 0;
    $community_card_count = 0;
    $review_card_count = 0;

    $user_id = $_GET['user_id'];

    //check user active
    $active_endpoint = $base_url . "user/getUser/checkUserActive.php?user_id=$user_id";
    $active_resource = file_get_contents($active_endpoint);
    $active_data = json_decode($active_resource, true);

    if($active_data){
        if($active_data['message']=="Account active."){
            //get user profile data
            $profile_endpoint = $base_url . "user/getUser/getProfileDataByUserID.php?user_id=$user_id";
            $profile_resource = file_get_contents($profile_endpoint);
            $profile_data = json_decode($profile_resource, true);

            $username = $profile_data[0]['user_name'];
            $user_art = $profile_data[0]['art_url'];
            $user_bio = $profile_data[0]['user_bio'];
            $user_location = $profile_data[0]['location_code']; 

            //get owned music
            $user_owned_endpoint = $base_url . "user/getUser/getOwnedAlbumsByUserID.php?user_id=$user_id";
            $user_owned_resource = @file_get_contents($user_owned_endpoint);
            $user_owned_data = json_decode($user_owned_resource, true);

            //get favourited music
            $favourited_endpoint = $base_url . "user/getUser/getFavouriteAlbumsByUserID.php?user_id=$user_id";
            $favourited_resource = @file_get_contents($favourited_endpoint);
            $favourited_data = json_decode($favourited_resource, true);

            //get joined communities
            $community_endpoint = $base_url . "user/getUser/getJoinedCommunitiesByUserID.php?user_id=$user_id";
            $community_resource = @file_get_contents($community_endpoint);
            $community_data = json_decode($community_resource, true);

            //get user reviews
            $review_endpoint = $base_url . "review/getReview/getReviewsByUserID.php?user_id=$user_id";
            $review_resource = @file_get_contents($review_endpoint);
            $review_data = json_decode($review_resource, true);

            //check if user is admin
            $check_admin_endpoint = $base_url . "user/getUser/getUserAdminStatus.php?user_id=$user_id";
            $check_admin_resource = file_get_contents($check_admin_endpoint);
            $check_admin_data = json_decode($check_admin_resource, true);

            if($check_admin_data[0]['AdminCount']){
                $is_admin = true;
            } else {
                $is_admin = false;
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if($username) { echo $username; } else { echo "Profile"; } ?></title>
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

        if(isset($_SESSION['postReview'])){
            include("includes/modal/postReviewModal.php");
        }

        if(isset($_SESSION['editReview'])){
            include("includes/modal/editReviewModal.php");
        }

        if(isset($_SESSION['reportUser'])){
            include("includes/modal/reportUserModal.php");
        }

        if(isset($_SESSION['userSettingsMessage'])){
            include("includes/modal/userSettingsModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        include("php/user/getUserAlbums.php");
        include("php/user/getUserCommunities.php");
        ?>

        <?php if($active_data and array_key_exists('message',$active_data) and $active_data['message']=="Account active.") { ?>

        <div class="row d-flex justify-content-center userPage">
            <div class="col-12 col-sm-5 col-md-4 userSidebar">
                <div class="row d-flex justify-content-center mb-3">
                    <div class="col-10 align-self-center">
                        <img src="<?php echo $user_art ?>" class="rounded-circle profilePic" width='200' height='200'/>
                    </div>
                </div>
                <div class="row d-flex justify-content-center text-center mb-2">
                    <?php if(strlen($username)>10){ ?>
                        <div class="col-12">
                    <?php } else { ?>
                        <div class="col-12 col-lg-3">
                    <?php } ?>
                        <h3><?php echo $username ?></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <h3><?php echo $user_location?></h3>
                    </div>
                </div>
                <div class="row text-center mb-2">
                    <p><?php echo stripslashes($user_bio) ?></p>
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
                <div class="row py-1 d-flex justify-content-end">
                    <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) {
                            if($AdminCount != 0) { ?>
                                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                            <?php } } else { ?>
                                <div class="col-1">
                            <?php } ?>
                        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) {
                            
                            //check if visiting user has already reported user
                            $reported_endpoint = $base_url . "user/getUser/checkUserReportExists.php?reporter=$logged_in_user_id&reportee=$user_id";
                            $reported_resource = file_get_contents($reported_endpoint);
                            $reported_data = json_decode($reported_resource, true);

                            $reported_flag = false;

                            if($reported_data){
                                $check_reported = $reported_data['message'];
                                if($check_reported == "Reported."){
                                    $reported_flag = true;
                                }
                            }

                            if($reported_flag){ ?>
                                <i id='reported' class='fas fa-flag fa-lg report' data-toggle='popover' title='Reported' data-content='Reported Content' data-target='reportIcon'></i>
                            <?php } else { ?>

                            <a role='button' href='php/user/confirmReportUser.php?user_id=<?php echo $user_id?>&reported=<?php echo $reported_flag ?>' class='text-reset text-decoration-none px-1'>
                                <i id='reportIcon' class='<?php if($reported_flag) { ?> fas <?php } else { ?> far <?php } ?> fa-flag fa-lg report' data-toggle='popover' title='Report' data-content='Report Content' data-target='reportIcon'></i>
                            </a>
                        <?php }
                        } ?>
                        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) {
                            if($AdminCount != 0) { ?>
                                <a role='button' href='php/user/confirmBanUser.php?user_id=<?php echo $user_id?>' class='text-reset text-decoration-none px-1'>
                                    <i id='banIcon' class='fas fa-ban fa-lg ban' data-toggle='popover' title='Ban' data-content='Ban User' data-target='banIcon'></i>
                                </a>
                                <?php if(!$is_admin) { ?>
                                <a role='button' href='php/user/confirmMakeAdmin.php?user_id=<?php echo $user_id?>' class='text-reset text-decoration-none px-1'>
                                    <i id='adminIcon' class='fas fa-tools fa-lg admin' data-toggle='popover' title='Admin' data-content='Give User Admin Rights' data-target='adminIcon'></i>
                                </a>
                                <?php } ?>
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
                                        if($user_owned_data){
                                            foreach($user_owned_data as $owned_album){
                                                $album_art_url = $owned_album['art_url'];
                                                $rating = $owned_album['AverageRating'];
                                                $album_title = $owned_album['album_title'];
                                                $album_artist = $owned_album['artist_name'];
                                                $album_id = $owned_album['album_id'];
    
                                                include("includes/music_card.php");
                                                $music_card_count++;
                                            }
                                        } else {
                                            echo "<h4 class='d-flex justify-content-center mt-3'>No owned music.</h4>";
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
                                        } else {
                                            echo "<h4 class='d-flex justify-content-center mt-3'>No favourited music.</h4>";
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
                                                $community_size_endpoint = $base_url . "community/getCommunity/getCommunitySizeByCommunityID.php?community_id=$community_id";
                                                $community_size_resource = file_get_contents($community_size_endpoint);
                                                $community_size_data = json_decode($community_size_resource, true);
    
                                                $community_members = $community_size_data[0]['MemberCount'];
    
                                                include("includes/community_card.php");
                                                $community_card_count++;
                                            }
                                        } else {
                                            echo "<h4 class='d-flex justify-content-center mt-3'>No joined communities.</h4>";
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
                                        } else {
                                            echo "<h4 class='d-flex justify-content-center mt-3'>No reviews.</h4>";
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

        <?php } else { ?>

        <div class="row align-items-center restrictedMessage">
            <div class="col text-center">
                <h3>Are you lost?</h3>
                <p>Sorry, this page isn't for you!</p>
            </div>
        </div>

        <?php } ?>

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