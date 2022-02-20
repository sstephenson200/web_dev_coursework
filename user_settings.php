<?php

    include("connections/dbconn.php");

    $user_id = $conn->real_escape_string($_GET['user_id']);

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
                <h2>Settings</h2>
            </div>
        </div>

        <div class="row px-5 mb-2">
            <div class="col-2">
                <h4>Profile</h4>
            </div>
            <div class="col-10 d-flex justify-content-end">
                <a type='button' class='btn styled_button' href='user_profile.php?user_id=<?php echo $user_id ?>'>View Profile</a>
            </div>
        </div>

        <div class="row px-5 mb-2">
            <div class="col-12 col-md-6">
                <p>Update your profile information.</p>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-10 col-md-10">

                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-12 col-md-4 align-self-center mb-4">
                        <img src="<?php echo $user_art ?>" class="rounded-circle profilePic"/>
                    </div>
                    <div class="col-10 col-md-6 text-center">
                        <div class="form-group mb-4">
                            <i class="fas fa-camera"></i>
                            <label for="updateProfilePic">Profile Picture URL</label>
                            <input type="url" class="form-control" id="updateProfilePic" placeholder="image.com" value="<?php echo $user_art ?>">
                        </div>
                        <div class="form-group mb-2">
                            <i class="fas fa-globe"></i>
                            <label for="updateLocation">Location</label>
                            <input type="text" class="form-control" id="updateLocation" placeholder="Where are you from?" value="UK">
                        </div>
                    </div>
                </div>

                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-10 text-center">
                        <div class="form-group mb-2">
                            <i class="fas fa-book"></i>
                            <label for="updateBio">User Bio</label>
                            <textarea class="form-control" id="updateBio" placeholder="What's your story?" rows="3">bio value blahblahblah</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row text-center mb-2">
                    <div class="col">
                        <a type='submit' class='btn styled_button'>Save Profile</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row px-5 mb-2">
            <div class="col-2">
                <h4>Account</h4>
            </div>
        </div>

        <div class="row mb-2 d-flex justify-content-center">
            <div class="col-10 text-center">
                <p>Account Settings Options</p>
            </div>
        </div>

        <!-- Footer -->
        <?php
            include("includes/footer.php");
        ?>

    </div>

</body>

</html>