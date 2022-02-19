<?php

    include("connections/dbconn.php");

    $music_card_count=0;
    $community_card_count=0;
    $review_card_count = 0;

    $user_query = "SELECT user.user_name, art.art_url FROM user
                    INNER JOIN art 
                    ON user.art_id = art.art_id 
                    WHERE user.user_id = 15";

    $user_result = $conn -> query($user_query);

    if(!$user_result){
        echo $conn -> error;
    }   

    $row = $user_result -> fetch_assoc();
    $username = $row['user_name'];
    $user_art = $row['art_url'];

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

        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 userSidebar">
                <div class="row justify-content-center mb-3">
                    <div class="col-10 align-self-center">
                        <img src="<?php echo $user_art ?>" class="rounded-circle profilePic"/>
                    </div>
                </div>
                <div class="row justify-content-center text-center mb-2">
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
                    <div clas="col-10">
                        <button type="submit" class="btn styled_button"><i class="fas fa-cog"></i> Settings</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-8">
                Tabbed Results
            </div>
        </div>

        <!-- Footer -->
        <?php
            include("includes/footer.php");
        ?>

    </div>

</body>

</html>