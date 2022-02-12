<?php

    include("connections/dbconn.php");

    $music_card_count=0;

    $album_query = "SELECT album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating;";

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
    <title>Browse Music</title>
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

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <!-- Title and Sorting Selector -->
        <div class="row musicBrowseTitle">
            <div class="col-10">
                <h2>Music</h2>
            </div>
            <div class="col-2 d-flex justify-content-end dropdown">
                <button id="musicSortFilter" type="button" class="btn dropdown-toggle p-1 styled_button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="musicSortFilter">
                    <li><a class="dropdown-item">Album Title</a></li>
                    <li><a class="dropdown-item">Artist</a></li>
                    <li><a class="dropdown-item">Genre</a></li>
                    <li><a class="dropdown-item" id="defaultMusicSort">Top 500 Albums</a></li>
                    <li><a class="dropdown-item">User Rating</a></li>
                    <li><a class="dropdown-item">Year</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-3 sidebar">
                <div class="row">
                    <h5>Filters</h5>
                </div>
                <div class="row">
                    <h6>Artist</h6>
                </div>
                <div class="row">
                    <h6>User Rating</h6>
                </div>
                <div class="row">
                    <h6>Genre</h6>
                </div>
                <div class="row">
                    <h6>Subgenre</h6>
                </div>
                <div class="row">
                    <h6>Year</h6>
                </div>
                <div class="row">
                    <ul class='nav justify-content-center'>
                        <li class='nav-item px-2'><a type='button' class='btn clearButton' href='#'>Clear</a></li>
                        <li class='nav-item px-2'><a type='button' class='btn applyButton' href='#'>Apply</a></li>
                    </ul>
                </div>
            </div>
            <!-- Album Grid -->
            <div class="col-9">
                    <?php

                    while($row = $album_result -> fetch_assoc()){

                    $album_art_url = $row['art_url'];
                    $rating = $row['AverageRating'];
                    $album_title = $row['album_title'];
                    $album_artist = $row['artist_name'];

                    include("includes/music_card.php");
                    $music_card_count++;

                    }
                    ?>

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
    include("js/browse_sort.php");
    include("js/card_functions.php");
?>

</html>