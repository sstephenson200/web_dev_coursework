<?php

    session_start();

    include("connections/dbconn.php");

    $screen_width = $_SESSION['width'];

    switch($screen_width) {
        case ($screen_width<992):
            $max_cards = 1;
            break;
        case ($screen_width<1200):
            $max_cards = 2;
            break;  
        case ($screen_width<1600):
            $max_cards = 3;
            break; 
        case ($screen_width>=1600):
            $max_cards = 4;
            break; 
        default: 
            $max_cards = 4;   
    }

    $music_card_count=0;
    $community_card_count=0;

    $trending_music_query = "SELECT album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album 
                            INNER JOIN review 
                            ON album.album_id = review.album_id 
                            INNER JOIN artist
                            ON album.artist_id = artist.artist_id
                            INNER JOIN art 
                            ON album.art_id = art.art_id
                            GROUP BY album.album_id 
                            ORDER BY AverageRating DESC
                            LIMIT 12;";

    
    $music_result = $conn -> query($trending_music_query);

    if(!$music_result){
		echo $conn -> error;
	}

    $top_communities_query = "SELECT community.community_name, community.community_description, art.art_url, COUNT(joined_communities.user_id) FROM community
                            INNER JOIN art
                            ON community.art_id = art.art_id
                            INNER JOIN joined_communities
                            ON community.community_id = joined_communities.community_id
                            GROUP BY community.community_id
                            ORDER BY COUNT(joined_communities.user_id) DESC
                            LIMIT 12;";

    $community_result = $conn -> query($top_communities_query);

    if(!$community_result){
        echo $conn -> error;
    }

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

    <script>

        var screen_size = 0;

        $(document).ready(function(){
            screen_size = window.innerWidth;

            $.ajax({
                type: "POST",
                url: "php/browser_width.php",
                data: "width="+screen_size
            });
        });

    </script>

</head>

<body>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
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
            <div id="musicCarousel" class="row carousel slide carousel-multi-item" data-bs-interval="false">

                <div class="col-1">
                    <button class="carousel-control-prev carouselArrowLeft" data-bs-target="#musicCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                </div>

                <div class="col-10">
                    <div class="carousel-inner">

                        <?php
                        $inner_music_card_count = 0;

                        echo "<script>console.log($screen_width)</script>";
                        echo "<script>console.log($max_cards)</script>";

                        while($row = $music_result -> fetch_assoc()){

                            if($music_card_count % $max_cards == 0) {
                                if($music_card_count < $max_cards){
                                    echo '<div class="carousel-item active">';
                                } else {
                                    echo '<div class="carousel-item">';
                                }
                                $inner_music_card_count = 0;
                            }

                            $album_art_url = $row['art_url'];
                            $rating = $row['AverageRating'];
                            $album_title = $row['album_title'];
                            $album_artist = $row['artist_name'];

                            include("includes/music_card.php");

                            $music_card_count++;
                            $inner_music_card_count++;

                            if($inner_music_card_count == $max_cards) {
                                echo '</div>';
                            }
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

        <!-- Communities Carousel -->

        <div class="topCommunities p-2">
            <div class="row">
                <h2>Top Communities</h2>
            </div>
            <div id="communityCarousel" class="row carousel slide carousel-multi-item" data-bs-interval="false">

                <div class="col-1">
                    <button class="carousel-control-prev carouselArrowLeft" data-bs-target="#communityCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                </div>

                <div class="col-10">
                    <div class="carousel-inner ">
                        
                            <?php
                            $inner_community_card_count = 0;

                            while($row = $community_result -> fetch_assoc()){

                                if($community_card_count % 4 == 0) {
                                    if($community_card_count < 4){
                                        echo '<div class="carousel-item active">';
                                    } else {
                                        echo '<div class="carousel-item">';
                                }
                                $inner_community_card_count = 0;
                            }

                                $community_art_url = $row['art_url'];
                                $community_name = $row['community_name'];
                                $community_description = $row['community_description'];
                                $community_members = $row['COUNT(joined_communities.user_id)'];

                                include("includes/community_card.php");

                                $community_card_count++;
                                $inner_community_card_count++;

                                if($inner_community_card_count == 4) {
                                echo '</div>';
                            }
                            }
                            ?>

                    </div>
                </div>

                <div class="col-1">
                    <button class="carousel-control-next carouselArrowRight" data-bs-target="#communityCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
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