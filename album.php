<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    $valid_album = true;

    //Card count variables
    $music_card_count = 0;
    $community_card_count = 0;
    $review_card_count = 0;

    $album_id = $_GET['album_id'];

    //check valid album
    $valid_endpoint = $base_url . "album/getAlbum/checkValidAlbum.php?album_id=$album_id";
    $valid_resource = file_get_contents($valid_endpoint);
    $valid_data = json_decode($valid_resource, true);

    if($valid_data){
        if($valid_data['message'] != "Album exists."){
            $valid_album = false;
        }
    }

    if($valid_album){
        //get album data
        $album_endpoint = $base_url . "album/getAlbum/getAlbumByID.php?album_id=$album_id";
        $album_resource = file_get_contents($album_endpoint);
        $album_data = json_decode($album_resource, true);

        $album_art_url = $album_data[0]['art_url'];
        $album_title = $album_data[0]['album_title'];
        $album_artist = $album_data[0]['artist_name'];
        $rating = $album_data[0]['AverageRating'];
        $spotify_id = $album_data[0]['spotify_id'];
        $year = $album_data[0]['year_value'];
        $genres = $album_data[0]['Genres'];
        $subgenres = $album_data[0]['Subgenres'];
        
        //get album songs
        $songs_endpoint = $base_url . "album/getAlbum/getSongsByAlbumID.php?album_id=$album_id";
        $songs_resource = @file_get_contents($songs_endpoint);
        $songs_data = json_decode($songs_resource, true);

        //get album reviews
        $reviews_endpoint = $base_url . "review/getReview/getReviewsByAlbumID.php?album_id=$album_id";
        $reviews_resource = @file_get_contents($reviews_endpoint);
        $reviews_data = json_decode($reviews_resource, true);

        //get related albums
        $album_artist_edited = urlencode($album_artist);
        $related_albums_endpoint = $base_url . "album/getAlbum/getAlbumsByArtistName.php?artist_name=$album_artist_edited";
        $related_albums_resource = @file_get_contents($related_albums_endpoint);
        $related_albums_data = json_decode($related_albums_resource, true);

        //get related communities
        $related_communities_endpoint = $base_url . "community/getCommunity/getCommunitiesByArtistName.php?artist_name=$album_artist_edited";
        $related_communities_resource = @file_get_contents($related_communities_endpoint);
        $related_communities_data = json_decode($related_communities_resource, true);

        include ("php/pagination/pagination_reviews.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if($valid_album) { echo $album_title; } else { echo "Album"; } ?></title>
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

        if(isset($_SESSION['albumMessage'])){
            include("includes/modal/albumModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        include("php/user/getUserAlbums.php");    
        include("php/user/compareUserAlbums.php");
        include("php/user/getUserCommunities.php");
        ?>

        <?php if($valid_album) { ?>

        <div class="row d-flex justify-content-center py-2">
            <div class="col-12 col-md-4">
                <img class='albumArt img-thumbnail mx-auto d-block h-75 w-auto' src='<?php echo $album_art_url ?>'>
                <div class="row d-flex justify-content-center mt-4 pl-2">
                    <div class='col-2 col-xl-1 own text-center'>
                    <a role='button'
                    <?php if(!isset($_SESSION['userLoggedIn'])) {
                         echo "href='php/user/processCardFunctionError.php'"; 
                        } else {
                            echo "href='php/user/processOwnedAlbum.php?album_id=$album_id&owned=$ownedFlag'";
                        } 
                    ?>>
                        <i id='ownIcon' class='fas <?php if($ownedFlag) { ?> fa-check <?php } else { ?> fa-plus <?php } ?> fa-2x own' data-toggle='popover' title='Own' data-content='Owned music' data-target='ownIcon'></i>
                    </a>
                    </div>
                    <div class='col-2 col-xl-1 favourite'>
                        <a role='button'
                        <?php if(!isset($_SESSION['userLoggedIn'])) {
                         echo "href='php/user/processCardFunctionError.php'"; 
                        } else {
                            echo "href='php/user/processFavouriteAlbum.php?album_id=$album_id&favourited=$favouriteFlag'";
                           } 
                        ?>>
                            <i id='favouriteIcon' class='<?php if($favouriteFlag) { ?> fas <?php } else { ?> far <?php } ?> fa-heart fa-2x favourite' data-toggle='popover' title='Favourite' data-content='Favourited Music' data-target='favouriteIcon'></i>
                        </a>
                    </div> 
                </div>   
            </div>
            <div class="col-12 col-md-8 text-center">
                <?php if(isset($_SESSION['userLoggedIn']) and $AdminCount != 0) { ?>
                    <div class="row">
                        <div class="col-3 col-sm-2 offset-9 offset-sm-10">
                            <a role='button px-1' href='php/album/confirmEditAlbum.php' class='text-reset text-decoration-none'>
                                <i id='editAlbum' class='fas fa-edit fa-lg editAlbum' data-toggle='popover' title='Edit' data-content='Edit Content' data-target='editAlbum'></i>
                            </a>
                            <a role='button px-1' href='php/album/confirmDeleteAlbum.php?album_id=<?php echo $album_id ?>' class='text-reset text-decoration-none'>
                                <i id='deleteAlbum' class='far fa-trash-alt fa-lg delete' data-toggle='popover' title='Delete' data-content='Delete Content' data-target='deleteAlbum'></i>
                            </a>
                        </div>
                    </div>  
                <?php } ?>
                <div class="row">
                    <h1 class="display-2 p-0"><?php echo $album_title?></h1>
                    <h1 class="display-4 mb-2">
                        <?php

                        if($rating != null){
                            $rating_rounded = floor($rating);
                            for($i=0; $i<$rating_rounded; $i++){
                                echo "<i class='fas fa-star fa-xs'></i>";
                            }
                            $rating_remainder = ($rating - $rating_rounded);

                            if($rating_remainder>=0.5){
                                echo "<i class='fas fa-star-half fa-xs'></i>";
                            }
                        }

                        ?>
                    </h1>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                        <h4>Artist:</h4>
                    </div>
                    <div class="col-8 col-md-6 col-lg-5 col-xl-5">
                        <h4 class="artist"><?php echo $album_artist?></h4>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                        <h4>Year:</h4>
                    </div>
                    <div class="col-8 col-md-6 col-lg-5 col-xl-5">
                        <h4><?php echo $year?></h4>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                        <h4>Genre:</h4>
                    </div>
                    <div class="col-8 col-md-6 col-lg-5 col-xl-5">
                        <h4>
                            <?php 
                                $genreList = "";
                                if($genres){
                                    foreach($genres as $genre){
                                        $genreList .= "$genre, ";
                                    }
                                    $genreList = rtrim($genreList, ", ");
                                }
                                echo $genreList;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mb-4">
                    <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                        <h4>Subgenre:</h4>
                    </div>
                    <div class="col-8 col-md-6 col-lg-5 col-xl-5">
                        <h4>
                            <?php 
                                $subgenreList = "";
                                if($subgenres){
                                    foreach($subgenres as $subgenre){
                                        $subgenreList .= "$subgenre, ";
                                    }
                                    $subgenreList = rtrim($subgenreList, ", ");
                                }
                                echo $subgenreList;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mb-2">
                    <div class="col-12 col-sm-6">
                        <?php if($spotify_id) {
                            echo "<iframe src='https://open.spotify.com/embed/album/$spotify_id' width='300' height='80' frameborder='0' allowtransparency='true' allow='encrypted-media'></iframe>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-2">
            <div class="col-2">
                <h2>Tracks</h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-10">
                <table class="table table-sm table-bordered table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Song Title</th>
                            <th scope="col">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $song_count = 1;
                        if($songs_data){
                            foreach($songs_data as $song){
                                $song_title = $song['song_title'];
                                $duration = $song['song_length'];
    
                                echo "<tr>
                                <th scope='row'>$song_count</th>
                                <td>$song_title</td>";
    
                                if($duration == null){
                                    echo "<td></td>";
                                } else {
                                    echo "<td>$duration</td>";
                                }
                                
                                echo "</tr>";
                                $song_count++; 
                            }    
                        }           
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-2">
            <div class="col-2">
                <h2>Reviews</h2>
            </div>
        </div>

        <?php if(isset($_SESSION['userLoggedIn'])) { ?>

        <div class="row d-flex justify-content-center">
            <div class="col-10 col-md-8 p-2 border bg-dark">
                <div class="row">
                    <h2>Your Review</h2>
                </div> 
                <form action="php/review/processPostReview.php" method="POST">
                    <div class="row d-flex justify-content-center">
                        <div class="col-6 col-sm-8">
                            <div class="form-group mb-3">
                            <label for="reviewTitle">Title</label>
                            <input type="text" class="form-control" id="reviewTitle" name="reviewTitle" maxlength="30" placeholder="Review Title" required="required">
                            <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
                            <input type="hidden" name="user_id" value="<?php echo $logged_in_user_id ?>" />
                            </div>
                        </div>
                        <div class="col-4 col-sm-2">
                            <label for="reviewRating">Rating</label>
                            <select class="form-select" aria-label="ratingSelector" id="reviewRating" name="reviewRating">
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-10">
                        <div class="form-group">
                            <label for="reviewText">Your Review</label>
                            <textarea class="form-control" id="reviewText" name="reviewText" rows="3" maxlength="250" placeholder="Please enter your review..." required="required"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="col-2 mb-2">
                        <button type="submit" name="submit" class="btn styled_button">Submit</button>
                    </div>
                </div> 
                </form>
            </div>  
        </div>

        <?php } ?>

        <div class="row d-flex justify-content-center m-4">
            <?php 
            if(empty($reviews_data)) {
                echo "<div class='col-10 col-sm-8 col-md-2'>
                        <h4>No reviews!</h4>
                        <p>Be the first, you trendsetter.</p>
                    </div>";
            } else {

                $rating_2dp = number_format($rating,2);

                $reviews_5_star = 0;
                $reviews_4_star = 0;
                $reviews_3_star = 0;
                $reviews_2_star = 0;
                $reviews_1_star = 0;

                foreach($reviews_data as $review){
                    switch($review['review_rating']){
                        case '5':
                            $reviews_5_star++;
                            break;
                        case '4':
                            $reviews_4_star++;
                            break;
                        case '3':
                            $reviews_3_star++;
                            break;
                        case '2':
                            $reviews_2_star++;
                            break;
                        case '1':
                            $reviews_1_star++;
                            break;
                        default:
                            break;
                    }
                }

                $review_scores = [$reviews_1_star, $reviews_2_star, $reviews_3_star, $reviews_4_star, $reviews_5_star];

                $total_reviews = count($reviews_data);            

                echo "<div class='col'>
                        <div class='row text-center'>
                            <div class='col-5'>
                                <h2>Average Rating: $rating_2dp</h2>
                            </div>
                            <div class='col-5'>
                            <h2>Review Scores ($total_reviews)</h2>
                            </div>
                        </div>
                        <div class='row d-flex justify-content-center'>";
                            
                        for ($i=5; $i>0; $i--) {
                            echo "<div class='col-12 col-md-8 col-lg-1'>";
                            for($j=0;$j<$i; $j++){
                                echo "<i class='fas fa-star'></i>";
                            }
                            $index = $i - 1;
                            echo " $review_scores[$index]";
                            echo "</div>";
                        }

                        echo "</div>
                    </div>";
            }
            ?>
        </div>

        <div class="row p-2">
            <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_review_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?album_id={$album_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_review_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_review_pages){ echo '#'; } else { echo "?album_id={$album_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <?php

            if($reviews_data){
                foreach($visible_reviews as $review){
                    $review_title = $review['review_title'];
                    $review_body = $review['review_text'];
                    $review_rating = $review['review_rating'];
                    $review_date = $review['review_date'];
                    $username = $review['user_name'];
                    $user_art = $review['art_url'];
                    $user_id = $review['user_id'];
    
                    echo "<div class='col-10 col-lg-5 mx-4 mb-3'>";
                    include("includes/review.php");
                    echo "</div>";
                    $review_card_count++; 
                }
            }            
            ?>
        </div>

        <div class="row p-2">
            <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_review_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?album_id={$album_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_review_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_review_pages){ echo '#'; } else { echo "?album_id={$album_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row m-3
            <?php if(!$related_albums_data or count($related_albums_data) == 1 ) { 
                echo "d-none";
            }
            ?>">
            <div class="col-12 col-sm-10 col-md-6">
                <h2>More Music From <?php echo $album_artist?></h2>
            </div>
        </div>

        <div class="row m-3">
            <div class="col py-3 px-2">

                <?php

                if($related_albums_data){
                    foreach($related_albums_data as $related_album){
                        $album_art_url = $related_album['art_url'];
                        $rating = $related_album['AverageRating'];
                        $album_title = $related_album['album_title'];
                        $album_artist = $related_album['artist_name'];
                        $album_id = $related_album['album_id'];
    
                        if($album_id != $_GET['album_id']){
                            include("includes/music_card.php");
                            $music_card_count++;
                        }
    
                    }
                }
                ?>

            </div>
        </div>

        <div class="row m-3
            <?php if(!$related_communities_data) { 
                echo "d-none";
            }
            ?>">
            <div class="col-12 col-sm-10 col-md-6">
                <h2>Communities For <?php echo $album_artist?></h2>
            </div>
        </div>

        <div class="row m-3">
            <div class="col py-3 px-2">

                <?php

                if($related_communities_data){
                    foreach($related_communities_data as $related_community){
                        $community_id = $related_community['community_id'];
                        $community_art_url = $related_community['art_url'];
                        $community_name = $related_community['community_name'];
                        $community_description = $related_community['community_description'];

                        include("php/user/compareUserCommunities.php");

                        //get community size
                        $community_size_endpoint = $base_url . "community/getCommunity/getCommunitySizeByCommunityID.php?community_id=$community_id";
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