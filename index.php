<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pebble Revolution</title>
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

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid showcase">
            <div class="row">
                <h1 class="display-2 welcomeMessage">Revolutionise your listening</h1>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-6 d-flex browseMusic">
                    <a type="button" class="btn btn-lg text-nowrap styled_button mt-3" href="album_browse.php">Browse Music &raquo;</a>
                </div>
                <div class="col-xs-12 col-sm-6 d-flex browseCommunity">
                    <a type="button" class="btn btn-lg text-nowrap styled_button mt-3" href="community_browse.php">Browse Communities
                        &raquo;</a>
                </div>
            </div>
        </div>

        <!-- Music Carousel-->
        <div class="trendingMusic p-2">
            <div class="row">
                <h2>Trending Music</h2>
            </div>
            <div id="musicCarousel" class="row carousel slide carousel-multi-item" data-bs-interval="false">

                <div class="col-1">
                    <button class="carousel-control-prev carouselArrowLeft" data-bs-target="#musicCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                </div>

                <div class="col-10">
                    <div class="carousel-inner ">
                        <div class="carousel-item active">

                            <?php
                            include("includes/music_card.php");
                            ?>

                            <div class="col-2 music mx-4">
                                <div class="card musicCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top albumArt" src="img/album_cover.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <p>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </p>
                                        <h6 class="card-title album">Sgt. Pepper's Lonely Hearts Club Band</h6>
                                        <h6 class="card-subtitle artist">The Beatles</h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-4 own">
                                            <a role="button">
                                                <i id="ownIcon" class="fas fa-plus fa-lg" data-toggle="popover"
                                                    title="Own" data-content="Add to owned music"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 favourite">
                                            <a role="button">
                                                <i id="favouriteIcon" class="far fa-heart fa-lg" data-toggle="popover"
                                                    title="Favourite" data-content="Add to your favourites"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 music mx-4">
                                <div class="card musicCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top albumArt" src="img/album_cover.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <p>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </p>
                                        <h6 class="card-title album">Sgt. Pepper's Lonely Hearts Club Band</h6>
                                        <h6 class="card-subtitle artist">The Beatles</h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-4 own">
                                            <a role="button">
                                                <i id="ownIcon" class="fas fa-plus fa-lg" data-toggle="popover"
                                                    title="Own" data-content="Add to owned music"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 favourite">
                                            <a role="button">
                                                <i id="favouriteIcon" class="far fa-heart fa-lg" data-toggle="popover"
                                                    title="Favourite" data-content="Add to your favourites"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 music mx-4">
                                <div class="card musicCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top albumArt" src="img/album_cover.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <p>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </p>
                                        <h6 class="card-title album">Sgt. Pepper's Lonely Hearts Club Band</h6>
                                        <h6 class="card-subtitle artist">The Beatles</h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-4 own">
                                            <a role="button">
                                                <i id="ownIcon" class="fas fa-plus fa-lg" data-toggle="popover"
                                                    title="Own" data-content="Add to owned music"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 favourite">
                                            <a role="button">
                                                <i id="favouriteIcon" class="far fa-heart fa-lg" data-toggle="popover"
                                                    title="Favourite" data-content="Add to your favourites"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="carousel-item">

                            <div class="col-2 music mx-4">
                                <div class="card musicCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top albumArt" src="img/album_cover.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <p>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </p>
                                        <h6 class="card-title album">Sgt. Pepper's Lonely Hearts Club Band</h6>
                                        <h6 class="card-subtitle artist">The Beatles</h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-4 own">
                                            <a role="button">
                                                <i id="ownIcon" class="fas fa-plus fa-lg" data-toggle="popover"
                                                    title="Own" data-content="Add to owned music"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 favourite">
                                            <a role="button">
                                                <i id="favouriteIcon" class="far fa-heart fa-lg" data-toggle="popover"
                                                    title="Favourite" data-content="Add to your favourites"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="carousel-item">

                            <div class="col-2 music mx-4">
                                <div class="card musicCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top albumArt" src="img/album_cover.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <p>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </p>
                                        <h6 class="card-title album">Sgt. Pepper's Lonely Hearts Club Band</h6>
                                        <h6 class="card-subtitle artist">The Beatles</h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-4 own">
                                            <a role="button">
                                                <i id="ownIcon" class="fas fa-plus fa-lg" data-toggle="popover"
                                                    title="Own" data-content="Add to owned music"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 favourite">
                                            <a role="button">
                                                <i id="favouriteIcon" class="far fa-heart fa-lg" data-toggle="popover"
                                                    title="Favourite" data-content="Add to your favourites"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-1">
                    <button class="carousel-control-next carouselArrowRight" data-bs-target="#musicCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- Communities Carousel -->

        <div class="topCommunities p-2">
            <div class="row">
                <h2>Top Communities</h2>
            </div>
            <div id="communityCarousel" class="row carousel slide carousel-multi-item" data-bs-interval="false">

                <div class="col-1">
                    <button class="carousel-control-prev carouselArrowLeft" data-bs-target="#communityCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                </div>

                <div class="col-10">
                    <div class="carousel-inner ">
                        <div class="carousel-item active">

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="carousel-item">

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">

                            <div class="col-2 community mx-4">
                                <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
                                    <img class="card-img-top communityArt" src="img/community_pic.jpg"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="card-title communityName">Clashing with Giants</h6>
                                        <h6 class="card-text communityDescription">A community for fans of The Clash! |
                                            46,000 fans
                                        </h6>
                                    </div>
                                    <div class="card-footer row border-secondary align-items-center mx-0">
                                        <div class="col-6 own">
                                            <a role="button">
                                                <i id="joinIcon" class="fas fa-user-plus fa-lg" data-toggle="popover"
                                                    title="Join" data-content="Join this community"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 view">
                                            <a href="#" class="btn">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-1">
                    <button class="carousel-control-next carouselArrowRight" data-bs-target="#communityCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>

            </div>

        </div>


        <!-- Footer -->
        <?php
            include("includes/footer.php");
        ?>

    </div>

</body>

<script type="text/javascript" src="js/card_functions.js"></script>

</html>