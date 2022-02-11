    <div class="jumbotron jumbotron-fluid trendingAlbum text-center bg-dark text-white" style = "background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('<?php echo $album_art_url ?>');">
        <div class="row">
            <h1><a role="button" href="album.php" class="albumLink"><?php echo $album_title ?></a></h1>
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
        <div class='row justify-content-center'>
            <div class='col-1 own'>
                <a role='button'>
                    <i id='ownIcon<?php echo $music_card_count ?>' class='fas fa-plus fa-lg own' data-toggle='popover' title='Own' data-content='Owned music' data-target='ownIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
            <div class='col-1 favourite'>
                <a role='button'>
                    <i id='favouriteIcon<?php echo $music_card_count ?>' class='far fa-heart fa-lg favourite' data-toggle='popover' title='Favourite' data-content='Favourited Music' data-target='favouriteIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
        </div>
    </div>