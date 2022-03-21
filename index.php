<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/authentication/processRememberMe.php");

    if(isset($_SESSION['rememberMe'])){
        setcookie("rememberMe", $_SESSION['rememberMe'][0], time() + (86400 * 30), "/");
    } 
    
    //Card count variables
    $music_card_count=0;
    $community_card_count=0;

    //get trending album data
    $album_endpoint = $base_url . "album/getAlbum/getTrendingAlbums.php";
    $album_resource = file_get_contents($album_endpoint);
    $album_data = json_decode($album_resource, true);

    //get top community data
    $community_endpoint = $base_url . "community/getCommunity/getTopCommunities.php";
    $community_resource = file_get_contents($community_endpoint);
    $community_data = json_decode($community_resource, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pebble Revolution</title>
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

    <?php
        if(isset($_SESSION['deletedAlbumMessage'])){
            include("includes/modal/deletedAlbumModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        include("php/user/getUser/getUserAlbums.php");   
        include("php/user/getUser/getUserCommunities.php"); 
        ?>

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid showcase">
            <div class="row">
                <h1 class="display-2 welcomeMessage">Revolutionise your listening</h1>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-6 d-flex browseMusic">
                    <a type="button" class="btn btn-lg text-nowrap styled_button mt-3" href="album_browse.php">Browse Music &raquo;</a>
                </div>
                <div class="col-xs-12 col-sm-6 d-flex browseCommunity">
                    <a type="button" class="btn btn-lg text-nowrap styled_button mt-3" href="community_browse.php">Browse Communities
                        &raquo;</a>
                </div>
            </div>
        </div>

        <!-- Music Carousel-->
        <div class="trendingMusic p-2">
            <div class="row">
                <h2>Trending Music</h2>
            </div>
            <div id="musicCarousel" class="row carousel slide carousel-multi-item">

                <div class="col-1">
                    <button class="carousel-control-prev carouselArrowLeft" data-bs-target="#musicCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                </div>

                <div class="col-10">
                    <div class="carousel-inner">

                        <?php

                        foreach ($album_data as $row) {
                            $album_art_url = $row['art_url'];
                            $rating = $row['AverageRating'];
                            $album_title = $row['album_title'];
                            $album_artist = $row['artist_name'];
                            $album_id = $row['album_id'];

                            if($music_card_count == 0){
                                echo '<div class="carousel-item active">';
                            } else{
                                echo '<div class="carousel-item">';
                            }

                            include("includes/trending_album.php");
                            echo '</div>';

                            $music_card_count++;
                        }

                        ?>
  
                    </div>
                </div>

                <div class="col-1">
                    <button class="carousel-control-next carouselArrowRight" data-bs-target="#musicCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- Top Communities -->

        <div class="topCommunities p-2">
            <div class="row">
                <h2>Top Communities</h2>
            </div>
            <div class="row">
                <?php

                foreach ($community_data as $row) {
                    echo "<div class='col-xs-12 col-sm-6 col-m-6 col-lg-6 col-xl-3 d-flex justify-content-center'>";

                    $community_id = $row['community_id'];
                    $community_art_url = $row['art_url'];
                    $community_name = $row['community_name'];
                    $community_description = $row['community_description'];

                    //get community size
                    $community_size_endpoint = $base_url . "community/getCommunity/getCommunitySizeByCommunityID.php?community_id=$community_id";
                    $community_size_resource = file_get_contents($community_size_endpoint);
                    $community_size_data = json_decode($community_size_resource, true);

                    $community_members = $community_size_data[0]['MemberCount'];

                    include("includes/community_card.php");
                    $community_card_count++;

                    echo "</div>";
                }

                ?>
             
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