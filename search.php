<?php

    include("connections/dbconn.php");
    include ("php/pagination.php");

    $music_card_count=0;
    $community_card_count=0;

    $album_query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    WHERE artist_name LIKE '%Beach Boys%'
                    OR album.album_title LIKE '%Beach Boys%'
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating
                    LIMIT $offset, $cardsPerPage;";

    $album_result = $conn -> query($album_query);

    if(!$album_result){
		echo $conn -> error;
	}

    $artist_query = "SELECT DISTINCT(artist.artist_name) FROM artist";

    $artist_result = $conn -> query($artist_query);

    if(!$artist_result){
		echo $conn -> error;
	}

    $genre_query = "SELECT DISTINCT(genre.genre_title) FROM genre";

    $genre_result = $conn -> query($genre_query);

    if(!$genre_result){
		echo $conn -> error;
	}

    $subgenre_query = "SELECT DISTINCT(subgenre.subgenre_title) FROM subgenre";

    $subgenre_result = $conn -> query($subgenre_query);

    if(!$subgenre_result){
		echo $conn -> error;
	}

    $year_query = "SELECT DISTINCT(floor(year_value/10)*10) AS decade FROM year_value";

    $year_result = $conn -> query($year_query);

    if(!$year_result){
		echo $conn -> error;
	}

    $community_query = "SELECT community.community_name, community.community_description, art.art_url, COUNT(joined_communities.user_id) FROM community
                        INNER JOIN art
                        ON community.art_id = art.art_id
                        INNER JOIN joined_communities
                        ON community.community_id = joined_communities.community_id
                        INNER JOIN artist
                        ON community.artist_id = artist.artist_id
                        WHERE community.community_name LIKE '%Beach Boys%'
                        OR artist.artist_name LIKE '%Beach Boys%'
                        GROUP BY community.community_id
                        LIMIT $offset, $cardsPerPage;";

    $community_result = $conn -> query($community_query);

    if(!$community_result){
        echo $conn -> error;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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
        <div class="row browseTitle">
            <div class="col-4">
                <h2>Search Results For "Beach Boys"</h2>
            </div>
            <div class="col-8 d-flex justify-content-end <?php if($total_album_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_album_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_album_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row sortFilterOptions p-3">
            <div class="col-6 col-sm-1">
                <button type="button" id="sidebarCollapse" class="btn filterButton">
                    <span>Toggle Filter <i class="fas fa-filter"></i></span>
                </button>
            </div>
            <div class="col-6 col-sm-11 d-flex justify-content-end dropdown">
                <button id="musicSortFilter" type="button" class="btn dropdown-toggle p-1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" aria-labelledby="musicSortFilter">
                    <li><a class="dropdown-item">Artist</a></li>
                    <li><a class="dropdown-item">Community Size</a></li>
                    <li><a class="dropdown-item">Genre</a></li>
                    <li><a class="dropdown-item">Subgenre</a></li>
                    <li><a class="dropdown-item">Title</a></li>
                    <li><a class="dropdown-item" id="defaultMusicSort">Top 500 Albums</a></li>
                    <li><a class="dropdown-item">User Rating</a></li>
                    <li><a class="dropdown-item">Year</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-12 col-md-3 sidebar" id="musicSidebar">
                <div class="row mb-2">
                    <h4>Filters</h4>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='' id='hideAlbumsCheckbox'>
                    <label class='form-check-label' for='hideAlbumsCheckbox'>Hide Albums</label>
                </div>
                <div class='form-check mb-2'>
                    <input class='form-check-input' type='checkbox' value='' id='hideCommunityCheckbox'>
                    <label class='form-check-label' for='hideCommunityCheckbox'>Hide Communities</label>
                </div>
                <div class="row mb-1">
                    <h5>Applied Filters</h5>
                </div>
                <div class="row d-flex justify-content-left mb-1">
                    <p>Option1 <i class="fas fa-times"></i></p>
                </div>
                <div class="row mb-1">
                    <h5>Artist</h5>
                </div>
                <div class="row mb-1">
                    <select class="form-select" aria-label="artistSelector">
                        <option selected>Select artist</option>
                        <?php
                        $artistCount = 0;
                        while($row = $artist_result -> fetch_assoc()){
                        $artist_name = $row['artist_name'];
                        echo "<option value='$artistCount'>$artist_name</option>";
                        $artistCount++;
                        }
                        ?>
                    </select>
                </div>
                <div class="row mb-1">
                    <h5>Genre</h5>
                </div>
                <div class="row mb-1">
                    <select class="form-select" aria-label="genreSelector">
                        <option selected>Select genre</option>
                        <?php
                        $genreCount = 0;
                        while($row = $genre_result -> fetch_assoc()){
                        $genre_title = $row['genre_title'];
                        echo "<option value='$genreCount'>$genre_title</option>";
                        $genreCount++;
                        }
                        ?>
                    </select>
                </div>
                <div class="row mb-1">
                    <h5>Subgenre</h5>
                </div>
                <div class="row mb-1">
                    <select class="form-select" aria-label="subgenreSelector">
                        <option selected>Select subgenre</option>
                        <?php
                        $subgenreCount = 0;
                        while($row = $subgenre_result -> fetch_assoc()){
                        $subgenre_title = $row['subgenre_title'];
                        echo "<option value='$subgenreCount'>$subgenre_title</option>";
                        $subgenreCount++;
                        }
                        ?>
                    </select>
                </div>
                <div class="row mb-1">
                    <a href="#ratingCollapse" class="text-decoration-none text-white" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="ratingCollapse">
                        <h5>User Rating <i class="fas fa-angle-down"></i></h5>
                    </a>
                </div>
                <div class="row collapse mb-1" id="ratingCollapse">
                    <?php
                        for($i=0; $i<5; $i++){
                            echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' value='' id='ratingCheckbox'>
                                <label class='form-check-label' for='ratingCheckbox'>";
                            for($j=5; $j>$i; $j--) {
                                echo "<i class='fas fa-star'></i>";  
                            }
                            echo "</label>
                            </div>";
                        }
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' value='' id='ratingCheckbox'>
                                <label class='form-check-label' for='ratingCheckbox'>No rating</label>
                                </div>";
                    ?>
                </div>
                <div class="row mb-1">
                    <a href="#yearCollapse" class="text-decoration-none text-white" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="yearCollapse">
                        <h5>Year <i class="fas fa-angle-down"></i></h5>
                    </a>
                </div>
                <div class="row collapse mb-1" id="yearCollapse">
                    <ul>
                        <?php
                        while($row = $year_result -> fetch_assoc()){
                        $decade = $row['decade'];
                        $decade = "'".substr($decade, 2)."s";
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' value='' id='ratingCheckbox'>
                                <label class='form-check-label' for='ratingCheckbox'>$decade</label>
                                </div>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="row">
                    <ul class='nav justify-content-center'>
                        <li class='nav-item px-2'><a type='button' class='btn clearButton' href='#'>Clear</a></li>
                        <li class='nav-item px-2'><a type='button' class='btn applyButton' href='#'>Apply</a></li>
                    </ul>
                </div>
            </div>
            <!-- Album Grid -->
            <div class="col py-3">

                <?php

                while($row = $album_result -> fetch_assoc()){

                $album_art_url = $row['art_url'];
                $rating = $row['AverageRating'];
                $album_title = $row['album_title'];
                $album_artist = $row['artist_name'];
                $album_id = $row['album_id'];

                if(isset($_POST['$hideAlbumsCheckbox'])){
                    continue;
                } else {
                    include("includes/music_card.php");
                    $music_card_count++;
                }

                }
                ?>

                <?php

                while($row = $community_result -> fetch_assoc()){

                $community_art_url = $row['art_url'];
                $community_name = $row['community_name'];
                $community_description = $row['community_description'];
                $community_members = $row['COUNT(joined_communities.user_id)'];

                if(isset($_POST['$hideCommunityCheckbox'])){
                    continue;
                } else {
                    include("includes/community_card.php");
                    $community_card_count++;
                }

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
    include("js/browse_sort.php");
    include("js/card_functions.php");
    include("js/show_filter.php");
?>

</html>