<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/authentication/processRememberMe.php");

    if(isset($_POST['search'])){
        $search = urlencode($_POST['search']);
        $_SESSION['search_title'] = $search;
        unset($_SESSION['search_data']);
        unset($_SESSION['filtered_search_data']);
    } else {
        $search = "";
    }

    //Card count variables
    $music_card_count=0;

    //Year count
    $year_count = 0;

    //filter variables
    $artist_filter = [];
    $genre_filter = [];
    $subgenre_filter = [];
    $rating_filter = [];
    $decade_filter = [];
    $search_filters = array('artists' => $artist_filter, 'genres' => $genre_filter, 'subgenres' => $subgenre_filter, 'ratings' => $rating_filter, 'decades' => $decade_filter);

    //set active_filters as session variable for use in filtering
    if(isset($_SESSION['search_filters'])){
        $search_filters = $_SESSION['search_filters'];
    }
    $_SESSION['search_filters'] = $search_filters;

    //get all artist data for filter menus
    $artist_endpoint = $base_url . "album/getAlbum/getArtists.php";
    $artist_resource = file_get_contents($artist_endpoint);
    $artist_data = json_decode($artist_resource, true);

    //get all genre data for filter menus
    $genre_endpoint = $base_url . "album/getAlbum/getGenres.php";
    $genre_resource = file_get_contents($genre_endpoint);
    $genre_data = json_decode($genre_resource, true);

    //get all subgenre data for filter menus
    $subgenre_endpoint = $base_url . "album/getAlbum/getSubgenres.php";
    $subgenre_resource = file_get_contents($subgenre_endpoint);
    $subgenre_data = json_decode($subgenre_resource, true);

    //get all year data for filter menus
    $year_endpoint = $base_url . "album/getAlbum/getDecades.php";
    $year_resource = file_get_contents($year_endpoint);
    $year_data = json_decode($year_resource, true);

    $decade_count = count($year_data);

    //get search data
    $search_endpoint = $base_url . "album/getAlbum/searchAlbums.php?search=$search";
    $search_resource = @file_get_contents($search_endpoint);
    $search_data = json_decode($search_resource, true);

    $filtered_search_data = [];

    //set album_data and filtered_data as session variables for use in sorting
    if(isset($_SESSION['search_data'])){
        $search_data = $_SESSION['search_data'];
    }
    $_SESSION['search_data'] = $search_data;

    if(isset($_SESSION['filtered_search_data'])){
        $filtered_search_data = $_SESSION['filtered_search_data'];
    }
    $_SESSION['filtered_search_data'] = $filtered_search_data;

    if(!empty($_SESSION['filtered_search_data'])){
        $album_count = count($_SESSION['filtered_search_data']);
    } else if($_SESSION['search_data']){
        $album_count = count($_SESSION['search_data']);
    } else {
        $album_count = 0;
    }

    //include pagination
    include ("php/pagination/pagination_search.php");

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

    <?php
        if(isset($_SESSION['email_submission'])){
            include("includes/modal/emailSignupModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        include("php/user/getUser/getUserAlbums.php");
        ?>

        <!-- Title -->
        <div class="row browseTitle">
            <div class="col-4">
                <h2>Search Results For "<?php echo $_SESSION['search_title'] ?>"</h2>
            </div>
            <!-- Pagination Controls -->
            <div class="col-8 d-flex justify-content-end <?php if($total_search_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_search_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_search_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Filter Toggle -->
        <form action="php/sort/processSearchSort.php" method="POST">
            <div class="row sortFilterOptions p-3">
                <div class="col-12 col-sm-6">
                    <button type="button" id="sidebarCollapse" class="btn filterButton">
                        <span>Toggle Filter <i class="fas fa-filter"></i></span>
                    </button>
                </div>
                <!-- Sorting Selector -->
                <div class="col-12 col-sm-5 col-md-4 offset-md-1 col-lg-3 offset-lg-2 d-flex justify-content-end dropdown mt-2 form-group">
                        <select name="searchSortFilter" id="searchSortFilter" class="form-select" aria-label="searchSortFilter">
                            <option value='artist' <?php if(isset($_SESSION['search_sort_type']) and $_SESSION['search_sort_type']=="artist"){ echo "selected"; } ?>>Sort By: Artist</option>
                            <option value='title' <?php if(isset($_SESSION['search_sort_type']) and $_SESSION['search_sort_type']=="title"){ echo "selected"; } ?>>Sort By: Album Title</option>
                            <option value='top500' <?php if(!isset($_SESSION['search_sort_type']) or $_SESSION['search_sort_type']=="top500"){ echo "selected"; } ?>>Sort By: Top 500 Albums</option>
                            <option value='rating' <?php if(isset($_SESSION['search_sort_type']) and $_SESSION['search_sort_type']=="rating"){ echo "selected"; } ?>>Sort By: User Rating</option>
                            <option value='year' <?php if(isset($_SESSION['search_sort_type']) and $_SESSION['search_sort_type']=="year"){ echo "selected"; } ?>>Sort By: Year</option>
                        </select>
                </div>
                <div class="col-12 col-sm-1 text-center form-group">
                        <button type="submit" class="btn mt-2 styled_button">Sort</button>
                </div>
            </div>
        </form>

        <div class="row resultsGrid">
            <!-- Filter Sidebar -->
            <div class="col-12 col-md-3 sidebar" id="musicSidebar">
                <div class="row mb-2">
                    <h4>Filters</h4>
                </div>
                <div class="row mb-1">
                    <h5>Applied Filters</h5>
                </div>
                <?php
                    if(isset($_SESSION['search_filters']['artists']) and !empty($_SESSION['search_filters']['artists'])) {

                        echo "<div class='row mb-1'>
                                <h6>Artist</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['search_filters']['artists'] as $artist) {

                            $artist_edited = urlencode($artist);

                            echo "<li class='form-group'>$artist 
                                    <a role='button' href='php/filter/search/removeSearchFilter.php?artist=$artist_edited'>
                                        <i id='deleteFilter$artist' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['search_filters']['genres']) and !empty($_SESSION['search_filters']['genres'])) {

                        echo "<div class='row mb-1'>
                                <h6>Genre</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['search_filters']['genres'] as $genre) {

                            $genre_edited = urlencode($genre);

                            echo "<li class='form-group'>$genre 
                                    <a role='button' href='php/filter/search/removeSearchFilter.php?genre=$genre_edited'>
                                        <i id='deleteFilter$genre' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                                
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['search_filters']['subgenres']) and !empty($_SESSION['search_filters']['subgenres'])) {

                        echo "<div class='row mb-1'>
                                <h6>Subgenre</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['search_filters']['subgenres'] as $subgenre) {

                            $subgenre_edited = urlencode($subgenre);

                            echo "<li class='form-group'>$subgenre 
                                    <a role='button' href='php/filter/search/removeSearchFilter.php?subgenre=$subgenre_edited'>
                                        <i id='deleteFilter$subgenre' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['search_filters']['ratings']) and !empty($_SESSION['search_filters']['ratings'])) {

                        echo "<div class='row mb-1'>
                                <h6>User Rating</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['search_filters']['ratings'] as $rating) {

                            $rating_edited = urlencode($rating);

                            echo "<li class='form-group'>";
                                    if($rating != 0){
                                        for($i=0; $i<$rating; $i++){
                                            echo "<i class='fas fa-star'></i>";  
                                        }
                                    } else {
                                        echo "No rating";  
                                    }
                                    echo "<a role='button' href='php/filter/search/removeSearchFilter.php?rating=$rating_edited'>
                                        <i id='deleteFilter$rating' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";      
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['search_filters']['decades']) and !empty($_SESSION['search_filters']['decades'])) {

                        echo "<div class='row mb-1'>
                                <h6>Year</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['search_filters']['decades'] as $decade) {

                            $decade_edited = urlencode($decade);

                            echo "<li class='form-group'>$decade 
                                    <a role='button' href='php/filter/search/removeSearchFilter.php?decade=$decade_edited'>
                                        <i id='deleteFilter$decade' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>"; 
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <form action="php/filter/search/processSearchFilter.php" method="POST">
                    <div class="row mb-1">
                        <h5>Artist</h5>
                    </div>
                    <div class="row mb-1">
                        <select name="searchArtistSelector" id="searchArtistSelector" class="form-select" aria-label="searchArtistSelector">
                            <option selected>Select artist</option>
                            <?php
                            foreach($artist_data as $artist){
                                echo "<option value='$artist[0]'>$artist[0]</option>";
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="row mb-1">
                        <h5>Genre</h5>
                    </div>
                    <div class="row mb-1">
                        <select name="searchGenreSelector" id="searchGenreSelector" class="form-select" aria-label="searchGenreSelector">
                            <option selected>Select genre</option>
                            <?php
                            foreach($genre_data as $genre){
                                echo "<option value='$genre[0]'>$genre[0]</option>";
                            }                       
                            ?>
                        </select>
                    </div>
                    <div class="row mb-1">
                        <h5>Subgenre</h5>
                    </div>
                    <div class="row mb-1">
                        <select name="searchSubgenreSelector" id="searchSubgenreSelector" class="form-select" aria-label="searchSubgenreSelector">
                            <option selected>Select subgenre</option>
                            <?php
                            foreach($subgenre_data as $subgenre){
                                echo "<option value='$subgenre[0]'>$subgenre[0]</option>";
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
                                $rating_value = 5 - $i;
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='$rating_value' id='ratingCheckbox' name='rating$rating_value'>
                                    <label class='form-check-label' for='ratingCheckbox'>";
                                for($j=5; $j>$i; $j--) {
                                    echo "<i class='fas fa-star'></i>";  
                                }
                                echo "</label>
                                </div>";
                            }
                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='0' id='ratingCheckbox' name='rating0'>
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
                                foreach($year_data as $year){
                                    $year_count++;
                                    echo "<div class='form-check'>
                                    <input type='hidden' name='decade_count' value='$decade_count' />
                                    <input class='form-check-input' type='checkbox' value='$year[0]' name='year$year_count' id='year$year_count'>
                                    <label class='form-check-label' for='year$year_count'>$year[0]</label>
                                    </div>";
                                } 
                                ?>
                        </ul>
                    </div>
                    <div class="row mb-5 d-flex justify-content-center form-group">
                        <div class="col-12 col-sm-4 mb-2 text-center">
                            <a type="button" class="btn clearButton" href="php/filter/search/clearSearchFilters.php">Clear</a>
                        </div>
                        <div class="col-12 col-sm-4 mb-2 text-center">
                            <button type="submit" class="btn  applyButton">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Results Grid -->
            <div class="col py-3">

                <?php

                if($visible_search_data) {
                    if($visible_search_data){
                        foreach($visible_search_data as $search){
                            $album_art_url = $search['art_url'];
                            $rating = $search['AverageRating'];
                            $album_title = $search['album_title'];
                            $album_artist = $search['artist_name'];
                            $album_id = $search['album_id'];
        
                            include("includes/music_card.php");
                            $music_card_count++;
                        }
                    }
                } else {
                    echo "<h2 class='d-flex justify-content-center mt-3'>No results!</h2>";
                    echo "<p class='d-flex justify-content-center'>Sorry, your search was a little too niche.</p>";
                }

                ?>
            </div>
        </div>

        <div class="row controlLower p-2">
            <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_search_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_search_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_search_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
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