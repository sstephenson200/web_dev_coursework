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
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <div class="row d-flex justify-content-center py-2">
            <div class="col-3">
                <img class='albumArt h-50' src='<?php echo $album_art_url ?>'>
            </div>
            <div class="col-6">
                <h2><?php echo $album_title ?></h2>
                <h3 class="artist"><?php echo $album_artist ?></h3>
            </div>
            <div class="col-3">
            <?php

            $rating_rounded = floor($rating);
            for($i=0; $i<$rating_rounded; $i++){
                echo "<i class='fas fa-star'></i>";
            }
            $rating_remainder = ($rating - $rating_rounded);

            if($rating_remainder>=0.5){
                echo "<i class='fas fa-star-half'></i>";
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