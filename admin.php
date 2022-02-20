<?php

    include("connections/dbconn.php");

    $pending_review_query = "SELECT review.review_id, review.review_date, user.user_name, user.user_id, album.album_id, review.review_title, review.review_text, review.review_rating FROM review 
                            INNER JOIN user 
                            ON review.user_id = user.user_id
                            INNER JOIN album
                            ON review.album_id = album.album_id
                            INNER JOIN status
                            ON review.status_id = status.status_id
                            WHERE status.status_title = 'Pending'
                            ORDER BY review.review_date";

    $pending_review_result = $conn -> query($pending_review_query);

    if(!$pending_review_result){
        echo $conn -> error;
    }

    $status_query = "SELECT status.status_title FROM status";

    $status_result = $conn -> query($status_query);

    if(!$status_result){
        echo $conn -> error;
    }

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

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

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
                                    while($row = $pending_review_result -> fetch_assoc()) {
                                        
                                        $review_id = $row['review_id'];
                                        $review_date = $row['review_date'];
                                        $review_date = date("d/m/Y", strtotime($review_date));
                                        $username = $row['user_name'];
                                        $user_id = $row['user_id'];
                                        $album_id = $row['album_id'];
                                        $review_title = $row['review_title'];
                                        $review_text = $row['review_text'];
                                        $review_rating = $row['review_rating'];

                                        echo "<tr>
                                            <th scope='row'>$review_id</th>
                                            <td>$review_date</td>
                                            <td><a role='button' href='user_profile.php?user_id=$user_id'>$username</a></td>
                                            <td><a role='button' href='album.php?album_id=$album_id'>$album_id</a></td>
                                            <td>$review_title</td>
                                            <td>$review_text</td>
                                            <td>$review_rating</td>
                                            <td>  
                                                <select class='form-select'>";

                                                while($row = $status_result -> fetch_assoc()) {
                                                    $status = $row['status_title'];
            
                                                    if($status == "Pending"){
                                                        echo "<option selected value='$status'>$status</option>";
                                                    } else {
                                                        echo "<option value='$status'>$status</option>";
                                                    }
            
                                                }

                                            echo "</select>
                                                    </td>
                                                </tr>";               
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn styled_button">Save</button>
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

        
        <!-- Footer -->
        <?php
            include("includes/footer.php");
        ?>

    </div>

</body>

</html>