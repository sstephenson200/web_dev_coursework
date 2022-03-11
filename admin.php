<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    //get pending reviews
    $pending_review_endpoint = $base_url . "review/getReviewsByStatus.php?status_title=Pending";
    $pending_review_resource = @file_get_contents($pending_review_endpoint);
    $pending_review_data = json_decode($pending_review_resource, true);

    //get reported reviews
    $reported_review_endpoint = $base_url . "review/getReviewsByStatus.php?status_title=Flagged";
    $reported_review_resource = @file_get_contents($reported_review_endpoint);
    $reported_review_data = json_decode($reported_review_resource, true);

    //get reported users
    $reported_users_endpoint = $base_url . "user/getReportedUsers.php";
    $reported_users_resource = @file_get_contents($reported_users_endpoint);
    $reported_users_data = json_decode($reported_users_resource, true);

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

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <?php if(isset($_SESSION['userLoggedIn']) and $AdminCount != 0) { ?>

        <div class="row browseTitle mb-2">
            <div class="col-2">
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
                                    if($pending_review_data){
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
    
                                            echo "<tr>
                                                <th scope='row'>$review_id</th>
                                                <td>$review_date</td>
                                                <td><a role='button' href='user_profile.php?user_id=$user_id'>$username</a></td>
                                                <td><a role='button' href='album.php?album_id=$album_id'>$album_id</a></td>
                                                <td>$review_title</td>
                                                <td>$review_text</td>
                                                <td>$review_rating</td>
                                                <td>  
                                                    <select class='form-select'>
                                                        <option value='Approved'>Approved</option>
                                                        <option selected value='Pending'>Pending</option>
                                                        <option value='Rejected'>Rejected</option>
                                                    </select>
                                                    </td>
                                                    </tr>";    
                                        }
                                    } else {
                                        echo "<h4 class='d-flex justify-content-center mt-3'>No pending reviews.</h4>";
                                        echo "<h5 class='d-flex justify-content-center mt-3'>Good job!</h5>";
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn styled_button">Save Changes</button>
                                </div>
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
            <div class="col-2">
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
                                    if($reported_review_data){
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
    
                                            echo "<tr>
                                                <th scope='row'>$review_id</th>
                                                <td>$review_date</td>
                                                <td><a role='button' href='user_profile.php?user_id=$user_id'>$username</a></td>
                                                <td><a role='button' href='album.php?album_id=$album_id'>$album_id</a></td>
                                                <td>$review_title</td>
                                                <td>$review_text</td>
                                                <td>$review_rating</td>
                                                <td>  
                                                    <select class='form-select'>
                                                        <option value='Approved'>Approved</option>
                                                        <option selected value='Flagged'>Flagged</option>
                                                        <option value='Rejected'>Rejected</option>
                                                    </select>
                                                </td>
                                                </tr>";               
                                        }
                                    } else {
                                        echo "<h4 class='d-flex justify-content-center mt-3'>No reported reviews.</h4>";
                                        echo "<h5 class='d-flex justify-content-center mt-3'>Good job!</h5>";
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn styled_button">Save Changes</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reportedCommunities">
                                <h5>Reported Communities</h5>
                            </div>
                            <div class="tab-pane fade" id="reportedUsers">
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
                                    if($reported_users_data){
                                        foreach($reported_users_data as $report){
                                            $report_id = $report['user_report_id'];
                                            $report_date = $report['report_date'];
                                            $report_date = date("d/m/Y", strtotime($report_date));
                                            $reporting_user = $report['reporting_user_id'];
                                            $reported_user = $report['reported_user_id'];
                                            $report_reasoning = $report['report_reasoning'];
    
                                            //get reporting username
                                            $reporting_user_endpoint = $base_url . "user/getProfileDataByUserID.php?user_id=$reporting_user";
                                            $reporting_user_resource = file_get_contents($reporting_user_endpoint);
                                            $reporting_user_data = json_decode($reporting_user_resource, true);
                                            $reporting_user_name = $reporting_user_data[0]['user_name'];
    
                                            //get reported username
                                            $reported_user_endpoint = $base_url . "user/getProfileDataByUserID.php?user_id=$reported_user";
                                            $reported_user_resource = file_get_contents($reported_user_endpoint);
                                            $reported_user_data = json_decode($reported_user_resource, true);
                                            $reported_user_name = $reported_user_data[0]['user_name'];
    
                                            echo "<tr>
                                                <th scope='row'>$report_id</th>
                                                <td>$report_date</td>
                                                <td><a role='button' href='user_profile.php?user_id=$reporting_user'>$reporting_user_name</a></td>
                                                <td><a role='button' href='user_profile.php?user_id=$reported_user'>$reported_user_name</a></td>
                                                <td>$report_reasoning</td>
                                                <td><button type='submit' class='btn styled_button'>Close Report</button>
                                                    <button type='submit' class='btn styled_button'>Ban User</button>
                                                </td>
                                                </tr>";      
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