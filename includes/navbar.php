<?php 

    $AdminCount = 0;
    $remember = new rememberMeController();

    if(isset($_SESSION['userLoggedIn'])){
        //get user_id
        $tokens = $remember -> parse_token($_SESSION['userLoggedIn']);
        $token = $tokens[0];
        $token_endpoint = $base_url . "user/getUserByToken.php?token=$token";
        $token_resource = @file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            $logged_in_user_id = $token_data[0]['user_id'];

            //get user profile data
            $user_endpoint = $base_url . "user/getProfileDataByUserID.php?user_id=$logged_in_user_id";
            $user_resource = file_get_contents($user_endpoint);
            $user_data = json_decode($user_resource, true);

            $logged_in_username = $user_data[0]['user_name'];
            $logged_in_user_art = $user_data[0]['art_url'];

            //check is user is admin
            $admin_endpoint = $base_url . "user/getUserAdminStatus.php?user_id=$logged_in_user_id";
            $admin_resource = file_get_contents($admin_endpoint);
            $admin_data = json_decode($admin_resource, true);
            
            if($admin_data){
                $AdminCount = $admin_data[0]['AdminCount'];
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Your account has been banned due to inappropriate behaviour.</div>";
            session_unset();
            session_destroy();
        }
         
    }
?>

<!-- Header with search bar -->
<div class='sticky-top site_header'>
<header class='p-2'>
    <div class='row'>
        <div class='col-12 col-sm-8 col-md-9'>
            <div class='d-flex mb-3 mb-lg-0'>
                <a href='index.php'><img class='me-2' width='40' height='32' src='img/logo.png'></a>
                <a href='index.php' class="text-light text-decoration-none"><span class='fs-4 title'>Pebble Revolution</span></a>
            </div>      
        </div>
        <div class='col-12 col-sm-4 col-md-3'>
            <div class='d-flex flex-row'>
                <form class='col-12 col-lg-auto mb-3 mb-lg-0 input-group' action='search.php' method='POST'>
                    <input type='search' class='form-control' placeholder='Search...' aria-label='Search' name='search'> 
                    <button class='btn styled_button' type='submit'><i class='fa fa-search'></i></button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Navbar with login/sign up buttons -->
<nav class='p-2'>
    <div class='row d-flex align-items-center'>
        <div class='col-3 col-md-8'>
            <nav class='navbar navbar-expand-sm navbar-dark'>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                    data-bs-target='#navbarMenu' aria-controls='navbarMenu' aria-expanded='false'
                    aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarMenu'>
                    <ul class='navbar-nav me-auto'>
                        <li class='nav-item'>
                            <a class='nav-link px-2 <?php if($_SERVER['SCRIPT_NAME']=='/web_dev_coursework/index.php') { echo 'active'; } ?>' aria-current='page' href='index.php'>Home</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link px-2 <?php if($_SERVER['SCRIPT_NAME']=='/web_dev_coursework/album_browse.php') { echo 'active'; } ?>' href='album_browse.php'>Music</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link px-2 <?php if($_SERVER['SCRIPT_NAME']=='/web_dev_coursework/community_browse.php') { echo 'active'; } ?>' href='community_browse.php'>Communities</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class='col-9 col-md-4 d-flex justify-content-end'>
            <?php 
                if(isset($_SESSION['userLoggedIn'])) {
            ?>
                <div class='dropdown'>
                    <a class='btn dropdown-toggle userDropdown' data-bs-toggle='dropdown'> 
                        <img src='<?php echo $logged_in_user_art ?>' class='rounded-circle' width='45' height='45'>  
                    </a>
                    <div class='dropdown-menu'>
                        <p class='dropdown-item'>Hello, <?php echo $logged_in_username . "!" ?></p>
                        <a class='dropdown-item' href='user_profile.php?user_id=<?php echo $logged_in_user_id ?>'>My Profile</a>
                        <a class='dropdown-item' href='user_settings.php?user_id=<?php echo $logged_in_user_id ?>'>Settings</a>
                        <?php if($AdminCount != 0) { ?>
                            <a class='dropdown-item' href='admin.php'>Admin</a>
                        <?php } ?>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='php/user/processLogout.php?user_id=<?php echo $logged_in_user_id ?>'>Logout</a>
                    </div>
                </div>
            <?php
                } else {
            ?>
            <ul class='nav'>
                <li class='nav-item px-2'><a type='button' class='btn styled_button' href='signup.php'>Sign Up</a></li>
                <li class='nav-item px-2'><a type='button' class='btn styled_button' href='login.php'>Login</a></li>
            </ul>
            <?php
                }
            ?>
        </div>
    </div>
</nav>
</div>