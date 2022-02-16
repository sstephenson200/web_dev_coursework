<?php

    include("connections/dbconn.php");

    $album_id = $conn->real_escape_string($_GET['album_id']);

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
                    WHERE review.album_id = $album_id";

    $review_result = $conn -> query($review_query);

    if(!$review_result){
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
                            echo "      ";
                            echo number_format($rating,2);
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

        <div class="row m-2">
            <div class="col">
                <?php 

                if(mysqli_num_rows($review_result) == 0) {
                    echo "<h4>No reviews!</h4>
                            <p>Be the first, you trendsetter.</p>";
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

</html>