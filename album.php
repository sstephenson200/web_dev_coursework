<?php

    $music_card_count = 0;
    $community_card_count = 0;
    $review_card_count = 0;

    include("connections/dbconn.php");

    $album_id = $conn->real_escape_string($_GET['album_id']);

    include ("php/pagination_reviews.php");

    $album_query = "SELECT album.album_title, album.spotify_id, art.art_url, artist.artist_name, year_value.year_value, AVG(review.review_rating) AS AverageRating from album
                    INNER JOIN art
                    ON album.art_id = art.art_id
                    INNER JOIN artist 
                    ON album.artist_id = artist.artist_id
                    INNER JOIN year_value
                    ON album.year_id = year_value.year_value_id
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    WHERE album.album_id = $album_id";

    $album_result = $conn -> query($album_query);

    if(!$album_result){
        echo $conn -> error;
    }

    $genre_query = "SELECT genre.genre_title FROM genre
                    INNER JOIN album_genre 
                    ON album_genre.genre_id = genre.genre_id
                    WHERE album_genre.album_id = $album_id";

    $genre_result = $conn -> query($genre_query);

    if(!$genre_result){
        echo $conn -> error;
    }

    $subgenre_query = "SELECT subgenre.subgenre_title FROM subgenre
                    INNER JOIN album_subgenre 
                    ON album_subgenre.subgenre_id = subgenre.subgenre_id
                    WHERE album_subgenre.album_id = $album_id";

    $subgenre_result = $conn -> query($subgenre_query);

    if(!$subgenre_result){
        echo $conn -> error;
    }

    $song_query = "SELECT song.song_title, song.song_length FROM song
                    WHERE song.album_id = $album_id";

    $song_result = $conn -> query($song_query);

    if(!$song_result){
        echo $conn -> error;
    }

    $review_query = "SELECT review_title, review_text, review_rating, review_date, user.user_name, art.art_url FROM review
                    INNER JOIN user
                    ON review.user_id = user.user_id
                    INNER JOIN art
                    ON user.art_id = art.art_id
                    WHERE review.album_id = $album_id
                    LIMIT $offset, $cardsPerPage";

    $review_result = $conn -> query($review_query);

    if(!$review_result){
        echo $conn -> error;
    }

    $total_ratings_query = "SELECT review.review_rating, COUNT(review.review_rating) FROM review
                            WHERE review.album_id = $album_id
                            GROUP BY review.review_rating";

    $total_ratings_result = $conn -> query($total_ratings_query);

    if(!$total_ratings_result){
        echo $conn -> error;
    }   

    $artist_query = "SELECT artist_name FROM artist 
                    INNER JOIN album
                    ON artist.artist_id = album.artist_id
                    WHERE album.album_id = $album_id";

    $artist_result = $conn -> query($artist_query);

    if(!$artist_result){
        echo $conn -> error;
    }   

    $artist_name = ($artist_result -> fetch_assoc())['artist_name'];

    $related_album_query = "SELECT album.album_id, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                            LEFT JOIN review 
                            ON album.album_id = review.album_id
                            INNER JOIN artist
                            ON album.artist_id = artist.artist_id
                            INNER JOIN art 
                            ON album.art_id = art.art_id
                            WHERE artist.artist_name = '$artist_name'
                            AND album.album_id!= '$album_id'
                            GROUP BY album.album_id";

    $related_album_result = $conn -> query($related_album_query);

    if(!$related_album_result){
        echo $conn -> error;
    }

    $related_community_query = "SELECT community.community_name, community.community_description, art.art_url, COUNT(joined_communities.user_id) FROM community
                                INNER JOIN art
                                ON community.art_id = art.art_id
                                INNER JOIN joined_communities
                                ON community.community_id = joined_communities.community_id
                                INNER JOIN artist
                                ON community.artist_id = artist.artist_id
                                WHERE artist.artist_name = '$artist_name'
                                GROUP BY community.community_id";

    $related_community_result = $conn -> query($related_community_query);

    if(!$related_community_result){
        echo $conn -> error;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
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
        $row = $album_result -> fetch_assoc();
        $album_art_url = $row['art_url'];
        $album_title = $row['album_title'];
        $album_artist = $row['artist_name'];
        $rating = $row['AverageRating'];
        $spotify_id = $row['spotify_id'];
        $year = $row['year_value'];
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <div class="row d-flex justify-content-center py-2">
            <div class="col-12 col-md-4">
                <img class='albumArt img-thumbnail mx-auto d-block h-75 w-auto' src='<?php echo $album_art_url ?>'>
                <div class="row d-flex justify-content-center mt-4 pl-2">
                    <div class='col-2 col-xl-1 own text-center'>
                    <a role='button'>
                        <i id='ownIcon' class='fas fa-plus fa-2x own' data-toggle='popover' title='Own' data-content='Owned music' data-target='ownIcon'></i>
                    </a>
                    </div>
                    <div class='col-2 col-xl-1 favourite'>
                        <a role='button'>
                            <i id='favouriteIcon' class='far fa-heart fa-2x favourite' data-toggle='popover' title='Favourite' data-content='Favourited Music' data-target='favouriteIcon'></i>
                        </a>
                    </div> 
                </div>   
            </div>
            <div class="col-12 col-md-8 text-center">
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
                                while($row = $genre_result -> fetch_assoc()) {
                                    $genre = $row['genre_title'];
                                    $genreList .= "$genre, ";
                                }
                                $genreList = rtrim($genreList, ", ");
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
                                while($row = $subgenre_result -> fetch_assoc()) {
                                    $subgenre = $row['subgenre_title'];
                                    $subgenreList .= "$subgenre, ";
                                }
                                $subgenreList = rtrim($subgenreList, ", ");
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
                        while($row = $song_result -> fetch_assoc()) { 
                            $song_title = $row['song_title'];
                            $duration = $row['song_length'];

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

        <div class="row d-flex justify-content-center">
            <div class="col-10 col-md-8 p-2 border bg-dark">
                <div class="row">
                    <h2>Your Review</h2>
                </div> 
                <div class="row d-flex justify-content-center">
                    <div class="col-6 col-sm-8">
                        <div class="form-group mb-3">
                        <label for="reviewTitle">Title</label>
                        <input type="text" class="form-control" id="reviewTitle" placeholder="Review Title" required="required">
                        </div>
                    </div>
                    <div class="col-4 col-sm-2">
                        <label for="reviewRating">Rating</label>
                        <select class="form-select" aria-label="ratingSelector" id="reviewRating">
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
                            <textarea class="form-control" id="reviewText" rows="3" placeholder="Please enter your review..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="col-2 mb-2">
                        <button type="submit" class="btn styled_button">Submit</button>
                    </div>
                </div> 
            </div>  
        </div>

        <div class="row d-flex justify-content-center m-4">
            <?php 
            if(mysqli_num_rows($review_result) == 0) {
                echo "<div class='col-10 col-sm-8 col-md-2'>
                        <h4>No reviews!</h4>
                        <p>Be the first, you trendsetter.</p>
                    </div>";
            } else {

                $rating_2dp = number_format($rating,2);
                $reviews_5_star = 10;
                $reviews_4_star = 6;
                $reviews_3_star = 11;
                $reviews_2_star = 3;
                $reviews_1_star = 0;
                $total_reviews = $reviews_5_star + $reviews_4_star + $reviews_3_star + $reviews_2_star + $reviews_1_star;            

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
                            echo " (10)";
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
             while($row = $review_result -> fetch_assoc()) {
                 $review_title = $row['review_title'];
                 $review_body = $row['review_text'];
                 $review_rating = $row['review_rating'];
                 $review_date = $row['review_date'];
                 $username = $row['user_name'];
                 $user_art = $row['art_url'];

                 echo "<div class='col-10 col-lg-5 mx-4 mb-3'>";
                 include("includes/review.php");
                 echo "</div>";
                 $review_card_count++;
                                    
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
            <?php if(mysqli_num_rows($related_album_result) == 0) { 
                echo "d-none";
            }
            ?>">
            <div class="col-12 col-sm-10 col-md-6">
                <h2>More Music From <?php echo $artist_name?></h2>
            </div>
        </div>

        <div class="row m-3">
            <div class="col py-3 px-2">

                <?php

                while($row = $related_album_result -> fetch_assoc()){

                $album_art_url = $row['art_url'];
                $rating = $row['AverageRating'];
                $album_title = $row['album_title'];
                $album_artist = $row['artist_name'];
                $album_id = $row['album_id'];

                include("includes/music_card.php");
                $music_card_count++;

                }
                ?>

            </div>
        </div>

        <div class="row m-3
            <?php if(mysqli_num_rows($related_community_result) == 0) { 
                echo "d-none";
            }
            ?>">
            <div class="col-12 col-sm-10 col-md-6">
                <h2>Communities For <?php echo $artist_name?></h2>
            </div>
        </div>

        <div class="row m-3">
            <div class="col py-3 px-2">

                <?php

                while($row = $related_community_result -> fetch_assoc()){

                    $community_art_url = $row['art_url'];
                    $community_name = $row['community_name'];
                    $community_description = $row['community_description'];
                    $community_members = $row['COUNT(joined_communities.user_id)'];
        
                    include("includes/community_card.php");
                    $community_card_count++;

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