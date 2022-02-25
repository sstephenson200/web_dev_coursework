<?php

    session_start();

    //Card count variables
    $music_card_count=0;

    $base_url = "http://localhost/web_dev_coursework/api/";

    //get all album data
    $album_endpoint = $base_url . "album/getAllAlbums.php";
    $album_resource = file_get_contents($album_endpoint);
    $album_data = json_decode($album_resource, true);

    $album_count = count($album_data);

    //set album_data as session variable for use in sorting
    if(isset($_SESSION['album_data'])){
        $album_data = $_SESSION['album_data'];
    }
    $_SESSION['album_data'] = $album_data;

    //get all genre data
    $genre_endpoint = $base_url . "album/getGenres.php";
    $genre_resource = file_get_contents($genre_endpoint);
    $genre_data = json_decode($genre_resource, true);

    include ("php/pagination/pagination_albums.php");

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

        <!-- Title -->
        <div class="row browseTitle">
            <div class="col-2 ">
                <h2>Music</h2>
            </div>
            <!-- Pagination Controls -->
            <div class="col-10 d-flex justify-content-end <?php if($total_album_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_album_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_album_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Filter Toggle -->
        <form action="php/sort/processMusicSort.php" method="POST">
            <div class="row sortFilterOptions p-3">
                <div class="col-12 col-sm-6">
                    <button type="button" id="sidebarCollapse" class="btn filterButton">
                        <span>Toggle Filter <i class="fas fa-filter"></i></span>
                    </button>
                </div>
                <!-- Sorting Selector -->
                    <div class="col-12 col-sm-5 col-md-4 offset-md-1 col-lg-3 offset-lg-2 d-flex justify-content-end dropdown mt-2 form-group">
                        <select name="musicSortFilter" id="musicSortFilter" class="form-control" aria-label="musicSortFilter">
                            <option value='artist' <?php if($_SESSION['sort_type']=="artist"){ echo "selected"; } ?>>Sort By: Artist</option>
                            <option value='title' <?php if($_SESSION['sort_type']=="title"){ echo "selected"; } ?>>Sort By: Album Title</option>
                            <option value='top500' <?php if($_SESSION['sort_type']=="top500" or !isset($_SESSION['sort_type'])){ echo "selected"; } ?>>Sort By: Top 500 Albums</option>
                            <option value='rating' <?php if($_SESSION['sort_type']=="rating"){ echo "selected"; } ?>>Sort By: User Rating</option>
                            <option value='year' <?php if($_SESSION['sort_type']=="year"){ echo "selected"; } ?>>Sort By: Year</option>
                        </select>
                </div>
                <div class="col-12 col-sm-1 text-center form-group">
                        <button type="submit" class="btn mt-2 styled_button">Sort</button>
                </div>
            </div>
        </form>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-12 col-md-3 sidebar" id="musicSidebar">
                <div class="row mb-2">
                    <h4>Filters</h4>
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
                        echo "<option value='$artistCount'>ABBA</option>";
                        $artistCount++;
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
                        foreach($genre_data as $genre){
                            $genreCount = 0;
                            echo "<option value='genre$genreCount'>$genre[0]</option>";
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
                        echo "<option value='$subgenreCount'>Blues</option>";
                        $subgenreCount++;
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
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' value='' id='ratingCheckbox'>
                                <label class='form-check-label' for='ratingCheckbox'>1970s</label>
                                </div>";
                        ?>
                    </ul>
                </div>
                <div class="row mb-5">
                    <ul class='nav d-flex justify-content-center'>
                        <li class='nav-item px-2'><a type='button' class='btn clearButton' href='#'>Clear</a></li>
                        <li class='nav-item px-2'><a type='button' class='btn applyButton' href='#'>Apply</a></li>
                    </ul>
                </div>
            </div>
            <!-- Album Grid -->
            <div class="col py-3">

                <?php

                foreach ($visible_album_data as $row) {
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

        <div class="row controlLower p-2">
            <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_album_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_album_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_album_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
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
    include("js/show_filter.php");
?>

</html>