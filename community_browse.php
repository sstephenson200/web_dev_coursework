<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    //Card count variables
    $community_card_count=0;    

    //filter variables
    $artist_filter = [];
    $genre_filter = [];
    $subgenre_filter = [];
    $community_filters = array('artists' => $artist_filter, 'genres' => $genre_filter, 'subgenres' => $subgenre_filter);

    //set community_filters as session variable for use in filtering
    if(isset($_SESSION['community_filters'])){
        $community_filters = $_SESSION['community_filters'];
    }
    $_SESSION['community_filters'] = $community_filters;

    //get all artist data for filter menus
    $artist_endpoint = $base_url . "album/getArtists.php";
    $artist_resource = file_get_contents($artist_endpoint);
    $artist_data = json_decode($artist_resource, true);

    //get all genre data for filter menus
    $genre_endpoint = $base_url . "album/getGenres.php";
    $genre_resource = file_get_contents($genre_endpoint);
    $genre_data = json_decode($genre_resource, true);

    //get all subgenre data for filter menus
    $subgenre_endpoint = $base_url . "album/getSubgenres.php";
    $subgenre_resource = file_get_contents($subgenre_endpoint);
    $subgenre_data = json_decode($subgenre_resource, true);

    //get all community data
    $community_endpoint = $base_url . "community/getAllCommunities.php";
    $community_resource = file_get_contents($community_endpoint);
    $community_data = json_decode($community_resource, true);

    $filtered_community_data = [];

    //set community_data and filtered_community_data as session variables for use in sorting
    if(isset($_SESSION['community_data'])){
        $community_data = $_SESSION['community_data'];
    }
    $_SESSION['community_data'] = $community_data;

    if(isset($_SESSION['filtered_community_data'])){
        $filtered_community_data = $_SESSION['filtered_community_data'];
    }
    $_SESSION['filtered_community_data'] = $filtered_community_data;

    if(!empty($_SESSION['filtered_community_data'])){
        $community_count = count($_SESSION['filtered_community_data']);
    } else if($_SESSION['community_data']){
        $community_count = count($_SESSION['community_data']);
    } else {
        $community_count = 0;
    }

    include ("php/pagination/pagination_communities.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Communities</title>
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
        ?>

        <!-- Title -->
        <div class="row browseTitle">
            <div class="col-2 ">
                <h2>Communities</h2>
            </div>
            <!-- Pagination Controls -->
            <div class="col-10 d-flex justify-content-end <?php if($total_community_pages<=1){ echo 'd-none';} ?>">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                        <li class="page-item <?php if($pageNumber >= $total_community_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_community_pages){ echo '#'; } else { echo "?pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Filter Toggle -->
        <form action="php/sort/processCommunitySort.php" method="POST">
            <div class="row sortFilterOptions p-3">
                <div class="col-12 col-sm-6">
                    <button type="button" id="sidebarCollapse" class="btn filterButton">
                        <span>Toggle Filter <i class="fas fa-filter"></i></span>
                    </button>
                </div>
                <!-- Sorting Selector -->
                    <div class="col-12 col-sm-5 col-md-4 offset-md-1 col-lg-3 offset-lg-2 d-flex justify-content-end dropdown mt-2 form-group">
                        <select name="communitySortFilter" id="communitySortFilter" class="form-select" aria-label="communitySortFilter">
                            <option value='size' <?php if(!isset($_SESSION['community_sort_type']) or $_SESSION['community_sort_type']=="size"){ echo "selected"; } ?>>Sort By: Community Size</option>
                            <option value='title' <?php if(isset($_SESSION['community_sort_type']) and $_SESSION['community_sort_type']=="title"){ echo "selected"; } ?>>Sort By: Community Name</option>
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
                    if(isset($_SESSION['community_filters']['artists']) and !empty($_SESSION['community_filters']['artists'])) {

                        echo "<div class='row mb-1'>
                                <h6>Artist</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['community_filters']['artists'] as $artist) {

                            echo "<li class='form-group'>$artist 
                                    <a role='button' href='php/filter/removeCommunityFilter.php?artist=$artist'>
                                        <i id='deleteFilter$artist' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['community_filters']['genres']) and !empty($_SESSION['community_filters']['genres'])) {

                        echo "<div class='row mb-1'>
                                <h6>Genre</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['community_filters']['genres'] as $genre) {
                            echo "<li class='form-group'>$genre 
                                    <a role='button' href='php/filter/removeCommunityFilter.php?genre=$genre'>
                                        <i id='deleteFilter$genre' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                                
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['community_filters']['subgenres']) and !empty($_SESSION['community_filters']['subgenres'])) {

                        echo "<div class='row mb-1'>
                                <h6>Subgenre</h6>
                            </div>
                            <div class='row d-flex justify-content-left mb-1'>
                                <ul>";

                        foreach($_SESSION['community_filters']['subgenres'] as $subgenre) {
                            echo "<li class='form-group'>$subgenre 
                                    <a role='button' href='php/filter/removeCommunityFilter.php?subgenre=$subgenre'>
                                        <i id='deleteFilter$subgenre' class='fas fa-times fa-lg' data-toggle='popover' title='Remove' data-content='Remove Filter'></i>
                                    </a>
                                </li>";     
                        }

                        echo "</ul>
                                </div>";
                    }
                ?>
                <form action="php/filter/processCommunityFilter.php" method="POST">
                    <div class="row mb-1">
                        <h5>Artist</h5>
                    </div>
                    <div class="row mb-1">
                        <select name="communityArtistSelector" id="communityArtistSelector" class="form-select" aria-label="communityArtistSelector">
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
                        <select name="communityGenreSelector" id="communityGenreSelector" class="form-select" aria-label="communityGenreSelector">
                            <option selected>Select genre</option>
                            <?php
                            foreach($genre_data as $genre){
                                echo "<option value='genre$genre[0]'>$genre[0]</option>";
                            }                       
                            ?>
                        </select>
                    </div>
                    <div class="row mb-1">
                        <h5>Subgenre</h5>
                    </div>
                    <div class="row mb-1">
                        <select name="communitySubgenreSelector" id="communitySubgenreSelector" class="form-select" aria-label="communitySubgenreSelector">
                            <option selected>Select subgenre</option>
                            <?php
                            foreach($subgenre_data as $subgenre){
                                echo "<option value='subgenre$subgenreCount[0]'>$subgenre[0]</option>";
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="row mb-5 mt-4 d-flex justify-content-center form-group">
                        <div class="col-12 col-sm-4 mb-2 text-center">
                            <a type="button" class="btn clearButton" href="php/filter/clearCommunityFilters.php">Clear</a>
                        </div>
                        <div class="col-12 col-sm-4 mb-2 text-center">
                            <button type="submit" class="btn  applyButton">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Community Grid -->
            <div class="col py-3">

                <?php

                if($visible_community_data) {
                    foreach ($visible_community_data as $row) {
                        $community_art_url = $row['art_url'];
                        $community_name = $row['community_name'];
                        $community_description = $row['community_description'];
                        $community_members = $row['MemberCount'];
    
                        include("includes/community_card.php");
                        $community_card_count++;
                    }
                } else {
                    echo "<h2 class='d-flex justify-content-center mt-3'>No results!</h2>";
                    echo "<p class='d-flex justify-content-center'>Sorry, your search was a little too niche.</p>";
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
    include("js/show_filter.php");
?>

</html>