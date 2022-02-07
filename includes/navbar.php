<!-- Header with search bar -->
<div class='sticky-top site_header'>
<header class='p-2'>
    <div class='row'>
        <div class='col-12 col-sm-8 col-md-9'>
            <a href='index.php' class='d-flex mb-3 mb-lg-0 text-light text-decoration-none'>
                <img class='me-2' width='40' height='32' src='img/logo.png'>
                <span class='fs-4 title'>Pebble Revolution</span>
            </a>
        </div>
        <div class='col-12 col-sm-4 col-md-3'>
            <div class='d-flex flex-row'>
                <form class='col-12 col-lg-auto mb-3 mb-lg-0 input-group search'>
                    <input type='search' class='form-control' placeholder='Search...' aria-label='Search'> 
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
            <ul class='nav'>
                <li class='nav-item px-2'><button type='button' class='btn'>Login</button></li>
                <li class='nav-item px-2'><button type='button' class='btn'>Sign up</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>