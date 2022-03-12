    <?php 

    include("php/user/compareUserAlbums.php");

    ?>
    
    <div class="jumbotron jumbotron-fluid trendingAlbum text-center bg-dark text-white" style = "background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('<?php echo $album_art_url ?>');">
        <div class="row">
            <h1><a role="button" href="album.php?album_id=<?php echo $album_id ?>" class="albumLink"><?php echo $album_title ?></a></h1>
        </div>
        <div class="row">
            <h2 class="artist"><?php echo $album_artist ?></h2>
        </div>
        <div class="row ">
            <p>
                <?php

                $rating_rounded = floor($rating);
                for($i=0; $i<$rating_rounded; $i++){
                    echo "<i class='fas fa-star'></i>";
                }
                $rating_remainder = ($rating - $rating_rounded);

                if($rating_remainder>=0.5){
                    echo "<i class='fas fa-star-half'></i>";
                }

                ?>
            </p>
        </div>
        <div class='row d-flex justify-content-center'>
            <div class='col-1 own'>
                <a role='button' 
                <?php if(!isset($_SESSION['userLoggedIn'])) {
                         echo "href='php/user/processCardFunctionError.php'";  
                        } 
                ?>>
                    <i id='ownIcon<?php echo $music_card_count ?>' class='fas <?php if($ownedFlag) { ?> fa-check <?php } else { ?> fa-plus <?php } ?>  fa-lg own' data-toggle='popover' title='Own' data-content='Owned music' data-target='ownIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
            <div class='col-1 favourite'>
                <a role='button'
                <?php if(!isset($_SESSION['userLoggedIn'])) {
                         echo "href='php/user/processCardFunctionError.php'";  
                        } 
                ?>>
                    <i id='favouriteIcon<?php echo $music_card_count ?>' class='<?php if($favouriteFlag) { ?> fas <?php } else { ?> far <?php } ?> fa-heart fa-lg favourite' data-toggle='popover' title='Favourite' data-content='Favourited Music' data-target='favouriteIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
        </div>
    </div>