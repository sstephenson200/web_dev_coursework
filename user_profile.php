<?php

    include("connections/dbconn.php");

    $user_id = $conn->real_escape_string($_GET['user_id']);

    include ("php/pagination.php");

    $music_card_count=0;
    $community_card_count=0;
    $review_card_count = 0;

    $user_query = "SELECT user.user_name, art.art_url FROM user
                    INNER JOIN art 
                    ON user.art_id = art.art_id 
                    WHERE user.user_id = $user_id";

    $user_result = $conn -> query($user_query);

    if(!$user_result){
        echo $conn -> error;
    }   

    $row = $user_result -> fetch_assoc();
    $username = $row['user_name'];
    $user_art = $row['art_url'];

    $owned_query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN owned_music
                    ON album.album_id = owned_music.album_id
                    WHERE owned_music.user_id = $user_id
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating
                    LIMIT $offset, $cardsPerPage;";

    $owned_result = $conn -> query($owned_query);

    if(!$owned_result){
		echo $conn -> error;
	}

    $favourite_query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN favourite_music
                    ON album.album_id = favourite_music.album_id
                    WHERE favourite_music.user_id = $user_id
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating
                    LIMIT $offset, $cardsPerPage;";

    $favourite_result = $conn -> query($favourite_query);

    if(!$favourite_result){
        echo $conn -> error;
    }

    $community_query = "SELECT community.community_name, community.community_description, art.art_url, COUNT(joined_communities.user_id) FROM community
                        INNER JOIN art
                        ON community.art_id = art.art_id
                        INNER JOIN joined_communities
                        ON community.community_id = joined_communities.community_id
                        WHERE joined_communities.user_id = 1
                        GROUP BY community.community_id
                        LIMIT $offset, $cardsPerPage;";

    $community_result = $conn -> query($community_query);

    if(!$community_result){
        echo $conn -> error;
    }

    $review_query = "SELECT album.album_title, album.album_id, artist.artist_name, review_title, review_text, review_rating, review_date, user.user_id, user.user_name, art.art_url FROM review
                    INNER JOIN user
                    ON review.user_id = user.user_id
                    INNER JOIN art
                    ON user.art_id = art.art_id
                    INNER JOIN album
                    ON review.album_id = album.album_id
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    WHERE review.user_id = $user_id
                    LIMIT $offset, $cardsPerPage";

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
    <title>Profile</title>
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

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-5 col-md-4 userSidebar">
                <div class="row d-flex justify-content-center mb-3">
                    <div class="col-10 align-self-center">
                        <img src="<?php echo $user_art ?>" class="rounded-circle profilePic"/>
                    </div>
                </div>
                <div class="row d-flex justify-content-center text-center mb-2">
                    <div class="col-12 col-lg-3">
                        <h3><?php echo $username ?></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <h3>UK</h3>
                    </div>
                </div>
                <div class="row text-center mb-2">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium.</p>
                </div>
                <div class="row text-center mb-2">
                    <div class="col">
                        <a type='button' class='btn styled_button' href='user_settings.php?user_id=<?php echo $user_id ?>'><i class="fas fa-cog"></i> Settings</a>
                        <a type='button' class='btn styled_button' href='admin.php?'><i class="fas fa-tools"></i> Admin</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-7 col-md-8">
                <div class="row py-1">
                    <div class="col-3 offset-9 col-md-1 offset-md-11">
                        <a role='button px-1'>
                            <i id='reportIcon' class='far fa-flag fa-lg report' data-toggle='popover' title='Report' data-content='Report Content' data-target='reportIcon'></i>
                        </a>
                        <a role='button px-1'>
                            <i id='banIcon' class='fas fa-ban fa-lg ban' data-toggle='popover' title='Ban' data-content='Ban User' data-target='banIcon'></i>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col mx-2">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link profileTabs active" href="#userOwned" data-bs-toggle="tab">Owned Music</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userFavourite" data-bs-toggle="tab">Favourite Music</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userCommunities" data-bs-toggle="tab">Communities</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userReviews" data-bs-toggle="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userPosts" data-bs-toggle="tab">Posts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#userComments" data-bs-toggle="tab">Comments</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="userOwned">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php

                                        while($row = $owned_result -> fetch_assoc()){

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

                                <div class="row p-2">
                                    <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_album_pages<=1){ echo 'd-none';} ?>">
                                        <nav aria-label="pagination">
                                            <ul class="pagination">
                                                <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                                                <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                                                <li class="page-item <?php if($pageNumber >= $total_album_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_album_pages){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userFavourite">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php

                                        while($row = $favourite_result -> fetch_assoc()){

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

                                <div class="row p-2">
                                    <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_album_pages<=1){ echo 'd-none';} ?>">
                                        <nav aria-label="pagination">
                                            <ul class="pagination">
                                                <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                                                <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                                                <li class="page-item <?php if($pageNumber >= $total_album_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_album_pages){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userCommunities">
                            <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php

                                        while($row = $community_result -> fetch_assoc()){

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

                                <div class="row p-2">
                                    <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_community_pages<=1){ echo 'd-none';} ?>">
                                        <nav aria-label="pagination">
                                            <ul class="pagination">
                                                <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                                                <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                                                <li class="page-item <?php if($pageNumber >= $total_community_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_community_pages){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="userReviews">
                                <div class="row">
                                    <div class="col py-3 px-2">

                                        <?php

                                        while($row = $review_result -> fetch_assoc()){

                                        $album_title = $row['album_title'];
                                        $album_id = $row['album_id'];
                                        $artist_name = $row['artist_name'];
                                        $review_title = $row['review_title'];
                                        $review_body = $row['review_text'];
                                        $review_rating = $row['review_rating'];
                                        $review_date = $row['review_date'];
                                        $username = $row['user_name'];
                                        $user_art = $row['art_url'];
                                        $user_id = $row['user_id'];

                                        echo "<div class='row d-flex justify-content-center mx-2'>
                                                <div class='row text-center'>
                                                    <div class='col-12 col-sm-6'>
                                                        <h6>Album: $album_title</h6>
                                                    </div>
                                                    <div class='col-12 col-sm-6'>
                                                        <h6>Artist: $artist_name</h6>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col text-center mb-2'>
                                                        <a href='album.php?album_id=$album_id' class='btn styled_button'>View</a>
                                                    </div>
                                                </div>
                                            </div>";
                        
                                        echo "<div class='row d-flex justify-content-center'>";
                                        echo "<div class='col-10 col-md-9 mx-4 mb-3'>";
                                        include("includes/review.php");
                                        echo "</div>";
                                        echo "</div>";
                                        $review_card_count++;

                                        }
                                        ?>

                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-2 offset-10 d-flex justify-content-center <?php if($total_community_pages<=1){ echo 'd-none';} ?>">
                                        <nav aria-label="pagination">
                                            <ul class="pagination">
                                                <li class="page-item <?php if($pageNumber <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber <= 1){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber - 1); } ?>">Previous</a></li>
                                                <li class="page-item disabled"><a class="page-link" href="<?php echo "?pageNumber=".($pageNumber); ?>"><?php echo $pageNumber ?></a></li>
                                                <li class="page-item <?php if($pageNumber >= $total_community_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageNumber >= $total_community_pages){ echo '#'; } else { echo "?user_id={$user_id}&pageNumber=".($pageNumber + 1); } ?>">Next</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade show" id="userPosts">
                                <h5>User's posts</h5>
                            </div>
                            <div class="tab-pane fade show" id="userComments">
                                <h5>User's comments</h5>
                            </div>
                        </div>
                    </div>
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