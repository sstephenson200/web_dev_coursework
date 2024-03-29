<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/authentication/processRememberMe.php");

    //get pending reviews
    $pending_review_endpoint = $base_url . "review/getReview/getReviewsByStatus.php?status_title=Pending";
    $pending_review_resource = @file_get_contents($pending_review_endpoint);
    $pending_review_data = json_decode($pending_review_resource, true);

    //get reported reviews
    $reported_review_endpoint = $base_url . "review/getReview/getReviewsByStatus.php?status_title=Flagged";
    $reported_review_resource = @file_get_contents($reported_review_endpoint);
    $reported_review_data = json_decode($reported_review_resource, true);

    //get reported users
    $reported_users_endpoint = $base_url . "user/getUser/getReportedUsers.php";
    $reported_users_resource = @file_get_contents($reported_users_endpoint);
    $reported_users_data = json_decode($reported_users_resource, true);

    //get all albums
    $album_endpoint = $base_url . "album/getAlbum/getAllAlbums.php";
    $album_resource = file_get_contents($album_endpoint);
    $album_data = json_decode($album_resource, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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

    <?php
        if(isset($_SESSION['adminMessage'])){
            include("includes/modal/adminModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <?php if(isset($_SESSION['userLoggedIn']) and $AdminCount != 0) { ?>

            <div class="row browseTitle mb-2">
            <div class="col">
                <h2>Add Album</h2>
                <p>Please ensure your entry is accurate.</p>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <form action="php/album/addAlbum/processAddAlbum.php" method="POST">
                    <div class="row d-flex justify-content-center">
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="albumTitle">Album Title</label>
                            <input type="text" class="form-control" id="albumTitle" name="albumTitle" maxlength="30" placeholder="Album Title" required="required">
                            </div>
                        </div>
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control" id="artist" name="artist" maxlength="30" placeholder="Artist" required="required">
                            </div>
                        </div>
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="art">Art URL</label>
                            <input type="url" class="form-control" id="art" name="art" placeholder="Art URL" required="required">
                            </div>
                        </div>
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="spotifyID">Spotify ID</label>
                            <input type="text" class="form-control" id="spotifyID" name="spotifyID" placeholder="Spotify ID">
                            </div>
                        </div>
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="rating">Album Rating</label>
                            <input type="text" class="form-control" id="rating" maxlength="3" name="rating" placeholder="Album Rating">
                            </div>
                        </div>
                        <div class="col-10 col-sm-5">
                            <div class="form-group mb-3">
                            <label for="year">Year</label>
                            <input type="text" class="form-control" id="year" name="year" maxlength="4" placeholder="Year Published" required="required">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-group mb-3">
                            <label for="genres">Genres</label>
                            <input type="text" class="form-control" id="genres" name="genres" placeholder="Genre1, Genre2, Genre3" required="required">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-group mb-3">
                            <label for="subgenres">Subgenres</label>
                            <input type="text" class="form-control" id="subgenres" name="subgenres" placeholder="Subgenre1, Subgenre2, Subgenre3" required="required">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-group mb-3">
                            <label for="songs">Album Tracks</label>
                            <textarea class="form-control" id="songs" name="songs" placeholder="Track1, Track2, Track3" rows="3" required="required"></textarea>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-group mb-3">
                            <label for="lengths">Track Lengths</label>
                            <textarea class="form-control" id="lengths" name="lengths" placeholder="TrackLength1, TrackLength2, TrackLength3" rows="3" required="required"></textarea>
                            </div>
                        </div>
                <div class="row d-flex justify-content-center text-center mt-2">
                    <div class="col mb-2">
                        <button type="submit" name="addAlbum" class="btn styled_button">Add Album</button>
                    </div>
                </div> 
                </form>
            </div>  
        </div>

        <div class="row browseTitle mb-2">
            <div class="col">
                <h2>Pending Content</h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col mx-2">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link profileTabs active" href="#pendingReviews" data-bs-toggle="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#pendingCommunities" data-bs-toggle="tab">Communities</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row mx-2 my-3">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pendingReviews">
                            <?php if($pending_review_data){ ?>
                                <form action="php/review/editReview/processPendingReviews.php" method="POST">
                                <table class="table table-sm table-bordered table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Album</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Body</th>
                                            <th scope="col">Rating</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>   

                                    <?php
                                        foreach($pending_review_data as $review){
                                            $review_id = $review['review_id'];
                                            $review_date = $review['review_date'];
                                            $review_date = date("d/m/Y", strtotime($review_date));
                                            $username = $review['user_name'];
                                            $user_id = $review['user_id'];
                                            $album_id = $review['album_id'];
                                            $review_title = $review['review_title'];
                                            $review_text = $review['review_text'];
                                            $review_rating = $review['review_rating'];
    
                                            ?>
                                             
                                            <tr>
                                                <th scope='row'><?php echo $review_id ?></th>
                                                    <td><?php echo $review_date ?></td>
                                                    <td><a role='button' href='user_profile.php?user_id=<?php echo $user_id ?>'><?php echo $username ?></a></td>
                                                    <td><a role='button' href='album.php?album_id=<?php echo $album_id ?>'><?php echo $album_id ?></a></td>
                                                    <td><?php echo stripslashes($review_title) ?></td>
                                                    <td><?php echo stripslashes($review_text) ?></td>
                                                    <td><?php echo $review_rating ?></td>
                                                    <td>  
                                                        <input type="hidden" name="review_id[]" value="<?php echo $review_id ?>" />
                                                        <select class='form-select' name="pendingReviewStatus[]">
                                                            <option value='Approved'>Approved</option>
                                                            <option selected value='Pending'>Pending</option>
                                                            <option value='Rejected'>Rejected</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                    
                                            <?php
                                        }
                                    } else {
                                        echo "<h4 class='d-flex justify-content-center mt-3'>No pending reviews.</h4>";
                                        echo "<h5 class='d-flex justify-content-center mt-3'>Good job!</h5>";
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <button type="submit" name="savePendingReviews" class="btn styled_button">Save Changes</button>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pendingCommunities">
                                <h5>Pending Communities</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row browseTitle mb-2">
            <div class="col">
                <h2>Reported Content</h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center userPage">
            <div class="col-12">
                <div class="row">
                    <div class="col mx-2">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link profileTabs active" href="#reportedReviews" data-bs-toggle="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#reportedCommunities" data-bs-toggle="tab">Communities</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#reportedUsers" data-bs-toggle="tab">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#reportedPosts" data-bs-toggle="tab">Posts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link profileTabs" href="#reportedComments" data-bs-toggle="tab">Comments</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mx-2 my-3">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="reportedReviews">
                            <?php if($reported_review_data){ ?>
                                <form action="php/review/editReview/processPendingReviews.php" method="POST">
                                <table class="table table-sm table-bordered table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Album</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Body</th>
                                            <th scope="col">Rating</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>   

                                    <?php
                                        foreach($reported_review_data as $review){
                                            $review_id = $review['review_id'];
                                            $review_date = $review['review_date'];
                                            $review_date = date("d/m/Y", strtotime($review_date));
                                            $username = $review['user_name'];
                                            $user_id = $review['user_id'];
                                            $album_id = $review['album_id'];
                                            $review_title = $review['review_title'];
                                            $review_text = $review['review_text'];
                                            $review_rating = $review['review_rating'];
    
                                        ?>

                                            <tr>
                                                <th scope='row'><?php echo $review_id ?></th>
                                                    <td><?php echo $review_date ?></td>
                                                    <td><a role='button' href='user_profile.php?user_id=<?php echo $user_id ?>'><?php echo $username ?></a></td>
                                                    <td><a role='button' href='album.php?album_id=<?php echo $album_id ?>'><?php echo $album_id ?></a></td>
                                                    <td><?php echo stripslashes($review_title) ?></td>
                                                    <td><?php echo stripslashes($review_text) ?></td>
                                                    <td><?php echo $review_rating ?></td>
                                                    <td>  
                                                        <input type="hidden" name="review_id[]" value="<?php echo $review_id ?>" />
                                                        <select class='form-select' name="pendingReviewStatus[]">
                                                            <option value='Approved'>Approved</option>
                                                            <option selected value='Flagged'>Flagged</option>
                                                            <option value='Rejected'>Rejected</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                        <?php
                                        }
                                    } else {
                                        echo "<h4 class='d-flex justify-content-center mt-3'>No reported reviews.</h4>";
                                        echo "<h5 class='d-flex justify-content-center mt-3'>Good job!</h5>";
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <button type="submit" name="saveReportedReviews" class="btn styled_button">Save Changes</button>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="reportedCommunities">
                                <h5>Reported Communities</h5>
                            </div>
                            <div class="tab-pane fade" id="reportedUsers">
                            <?php if($reported_users_data){ ?>
                                <table class="table table-sm table-bordered table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Reporting User</th>
                                            <th scope="col">Reported User</th>
                                            <th scope="col">Report Reasoning</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>   

                                    <?php
                                        foreach($reported_users_data as $report){
                                            $report_id = $report['user_report_id'];
                                            $report_date = $report['report_date'];
                                            $report_date = date("d/m/Y", strtotime($report_date));
                                            $reporting_user = $report['reporting_user_id'];
                                            $reported_user = $report['reported_user_id'];
                                            $report_reasoning = $report['report_reasoning'];
    
                                            //get reporting username
                                            $reporting_user_endpoint = $base_url . "user/getUser/getProfileDataByUserID.php?user_id=$reporting_user";
                                            $reporting_user_resource = file_get_contents($reporting_user_endpoint);
                                            $reporting_user_data = json_decode($reporting_user_resource, true);
                                            $reporting_user_name = $reporting_user_data[0]['user_name'];
    
                                            //get reported username
                                            $reported_user_endpoint = $base_url . "user/getUser/getProfileDataByUserID.php?user_id=$reported_user";
                                            $reported_user_resource = file_get_contents($reported_user_endpoint);
                                            $reported_user_data = json_decode($reported_user_resource, true);
                                            $reported_user_name = $reported_user_data[0]['user_name'];

                                            ?>
                                            <tr>
                                                <th scope='row'><?php echo $report_id ?></th>
                                                <td><?php echo $report_date ?></td>
                                                <td><a role='button' href='user_profile.php?user_id=<?php echo $reporting_user ?>'><?php echo $reporting_user_name ?></a></td>
                                                <td><a role='button' href='user_profile.php?user_id=<?php echo $reported_user ?>'><?php echo $reported_user_name ?></a></td>
                                                <td><?php echo stripslashes($report_reasoning) ?></td>
                                                <form action="php/user/editUser/processReportedUser.php" method="POST">
                                                    <input type="hidden" name="user_id" value="<?php echo $reported_user ?>" />
                                                    <input type="hidden" name="report_id" value="<?php echo $report_id ?>" />
                                                    <td><button type='submit' name="closeReport" class='btn styled_button'>Close Report</button>
                                                        <button type='submit' name="banUser" class='btn styled_button'>Ban User</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php    
                                        }
                                    } else {
                                        echo "<h4 class='d-flex justify-content-center mt-3'>No reported users.</h4>";
                                        echo "<h5 class='d-flex justify-content-center mt-3'>Good job!</h5>";
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="reportedPosts">
                                <h5>Reported Posts</h5>
                            </div>
                            <div class="tab-pane fade" id="reportedComments">
                                <h5>Reported Comments</h5>
                            </div>
                        </div>
                    </div>
                </div>

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

</html>