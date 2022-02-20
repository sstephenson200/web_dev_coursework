<?php

    include("connections/dbconn.php");

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
            <div class="col-10">
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
                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pendingReviews">
                                <h5>Pending Reviews</h5>
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