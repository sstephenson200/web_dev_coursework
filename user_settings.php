<?php

    $base_url = "http://localhost/web_dev_coursework/api/";

    session_start();

    include("php/user/processRememberMe.php");

    $user_id = $_GET['user_id'];

    //get user data
    $profile_endpoint = $base_url . "user/getUser/getProfileDataByUserID.php?user_id=$user_id";
    $profile_resource = file_get_contents($profile_endpoint);
    $profile_data = json_decode($profile_resource, true);
    
    $username = $profile_data[0]['user_name'];
    $user_art = $profile_data[0]['art_url'];
    $user_bio = $profile_data[0]['user_bio'];
    $user_location = $profile_data[0]['location_code'];
    $user_location_name = $profile_data[0]['location_name'];
    $user_contact_permissions = $profile_data[0]['user_contact_permissions'];

    //get all location options
    $location_endpoint = $base_url . "user/getUser/getUserLocationName.php";
    $location_resource = file_get_contents($location_endpoint);
    $location_data = json_decode($location_resource, true);

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

    <?php
        if(isset($_SESSION['email_submission'])){
            include("includes/modal/emailSignupModal.php");
        }

        if(isset($_SESSION['userSettingsMessage'])){
            include("includes/modal/userSettingsModal.php");
        }
    ?>

    <div class="container-fluid p-0 content">

        <?php
        include("includes/navbar.php");
        ?>

        <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username == $username) { ?>

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

        <form action="php/user/processProfileUpdate.php" method="POST">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-sm-10">
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-12 col-md-4 align-self-center mb-4">
                            <img src="<?php echo $user_art ?>" class="rounded-circle profilePic" width='200' height='200'/>
                        </div>
                        <div class="col-10 col-md-6 text-center">
                            <div class="form-group mb-4">
                                <i class="fas fa-camera"></i>
                                <label for="updateProfilePic">Profile Picture URL</label>
                                <input type="url" class="form-control" id="updateProfilePic" name="updateProfilePic" placeholder="image.com" value="<?php echo $user_art ?>" required="required">
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-globe"></i>
                                <label for="updateLocation">Location</label>
                                <select class="form-select" name="updateLocation">
                                    <?php
                                        foreach($location_data as $location){
                                            $location = $location['location_name'];

                                            if($location == $user_location_name){
                                                echo "<option selected value='$location'>$location</option>";
                                            } else {
                                                echo "<option value='$location'>$location</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-10 text-center">
                            <div class="form-group mb-2">
                                <i class="fas fa-book"></i>
                                <label for="updateBio">User Bio</label>
                                <textarea class="form-control" id="updateBio" name="updateBio" maxlength="250" placeholder="What's your story?" rows="3" required="required"><?php echo stripslashes($user_bio)?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mb-2">
                        <div class="col">
                            <div class="form-group">
                                <button type="submit" name="saveProfile" class="btn styled_button">Save Profile</button>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </form>

        <div class="row px-5 mb-2">
            <div class="col-2">
                <h4>Account</h4>
            </div>
        </div>

        <div class="row px-5 mb-2">
            <div class="col-12 col-md-6">
                <p>Update your account settings.</p>
            </div>
        </div>

        <div class="row d-flex justify-content-center px-2">
            <div class="col-12 col-sm-10">

                <div class="row">
                    <div class="col">
                        <h5>Email Preferences</h5>
                        <p>If you'd like, we can send you updates on Pebble Revolution.</p>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10">
                        <form action="php/user/processEmailPreferencesUpdate.php" method="POST">
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-check" >
                                        <input class="form-check-input" type="radio" name="radio" id="emailOptIn" value="1" <?php if($user_contact_permissions=="1"){ echo "checked"; } ?>>
                                        <label class="form-check-label" for="emailOptIn">Receive All Emails</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio" id="emailOptOut" value="0" <?php if($user_contact_permissions=="0"){ echo "checked"; } ?>>
                                        <label class="form-check-label" for="emailOptOut">Account Related Emails Only</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center mb-2">
                                <div class="col">
                                    <button type='submit' name="updateEmailPreferences" class='btn styled_button'>Save Email Preferences</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        <div class="row d-flex justify-content-center px-2">
            <div class="col-12 col-sm-10">

                <div class="row">
                    <div class="col">
                        <h5>Change Your Email Address</h5>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-8">
                        <form action="php/user/confirmEmailUpdate.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="emailReset">New Email Address</label>
                                <input type="email" class="form-control" id="emailReset" name="emailReset" placeholder="name@example.com" required="required">
                            </div>

                            <div class="row text-center mb-2">
                                <div class="col">
                                    <button type='submit' name="changeEmail" class='btn styled_button'>Update Email</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row d-flex justify-content-center px-2">
            <div class="col-12 col-sm-10">

                <div class="row">
                    <div class="col">
                        <h5>Change Your Username</h5>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-8">
                        <form action="php/user/confirmUsernameUpdate.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="usernameReset">New Username</label>
                                <input type="text" class="form-control" id="usernameReset" name="usernameReset" placeholder="Username" required="required">
                            </div>

                            <div class="row text-center mb-2">
                                <div class="col">
                                    <button type='submit' name="changeUsername" class='btn styled_button'>Update Username</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row d-flex justify-content-center px-2">
            <div class="col-12 col-sm-10">

                <div class="row">
                    <div class="col">
                        <h5>Change Your Password</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <a type="button" class="btn loginLink" href="forgot_password.php">Forgot your password?</a>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-8">
                        <form action="php/user/processPasswordUpdate.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="passwordResetOld">Old Password</label>
                                <input type="password" class="form-control" id="passwordResetOld" name="passwordResetOld" placeholder="Password" required="required">
                            </div>

                            <div class="form-group mb-3">
                                <label for="passwordResetNew1">New Password</label>
                                <input type="password" class="form-control" id="passwordResetNew1" name="passwordResetNew1" placeholder="Password" required="required">
                            </div>

                            <div class="form-group mb-3">
                                <label for="passwordResetNew2">Confirm New Password</label>
                                <input type="password" class="form-control" id="passwordResetNew2" name="passwordResetNew2" placeholder="Password" required="required">
                            </div>

                            <div class="row text-center mb-2">
                                <div class="col">
                                    <button type='submit' name="changePassword" class='btn styled_button'>Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row d-flex justify-content-center px-2">
            <div class="col-12 col-sm-10">

                <div class="row">
                    <div class="col">
                        <h5>Delete Your Account</h5>
                    </div>
                </div>

                <div class="row">
                            <div class="col">
                                <p>Ready to leave the revolution? We'll be sorry to see you go.</p>
                            </div>
                        </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-8">

                        <div class="row text-center mb-2">
                            <div class="col">
                                <a type='submit' name="deleteAccount" href='php/user/confirmDeleteAccount.php' class='btn styled_button'>Delete Account</a>
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