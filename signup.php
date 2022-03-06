<?php
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
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

        <div class="row signup d-flex justify-content-center py-2">
            <div class="col-10 col-sm-6 col-md-5 col-lg-4 col-xl-3 signupForm border px-3">
                <div class="text-center mt-3">
                    <h3>Create An Account</h3>
                    <p>Have an account?<a type="button" class="btn loginLink" href="login.php">Login</a></p>
                </div>
                <div class="form-group mb-3">
                    <i class="fas fa-envelope"></i>
                    <label for="emailSignup">Email Address</label>
                    <input type="email" class="form-control" id="emailSignup" placeholder="name@example.com" required="required">
                </div>
                <div class="form-group mb-3">
                    <i class="fas fa-user"></i>
                    <label for="usernameSignup">Username</label>
                    <input type="text" class="form-control" id="usernameSignup" placeholder="Username" required="required">
                </div>
                <div class="form-group mb-3">
                    <i class="fas fa-lock"></i>
                    <label for="password1Signup">Password</label>
                    <input type="text" class="form-control" id="password1Signup" placeholder="Password" required="required">
                </div>
                <div class="form-group mb-3">
                    <i class="fas fa-key"></i>
                    <label for="password2Signup">Confirm Password</label>
                    <input type="text" class="form-control" id="password2Signup" placeholder="Password" required="required">
                </div>
                <div class="text-center mb-3">
                    <button type="submit" class="btn styled_button">Submit</button>
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