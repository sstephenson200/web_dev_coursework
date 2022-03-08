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
                if(isset($_SESSION['userID_LoggedIn'])) {
            ?>
                <div class='dropdown'>
                    <a class='btn btn-warning dropdown-toggle' data-bs-toggle='dropdown'> Dropdown </a>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='user_profile.php?user_id=<?php echo $_SESSION['userID_LoggedIn'] ?>'>My Profile</a>
                        <a class='dropdown-item' href='#'>My Music</a>
                        <a class='dropdown-item' href='#'>My Communities</a>
                        <a class='dropdown-item' href='#'>My Reviews</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='user_settings.php?user_id=<?php echo $_SESSION['userID_LoggedIn'] ?>'>Settings</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='php/user/processLogout.php'>Logout</a>
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