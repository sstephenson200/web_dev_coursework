<div class='col-2 music mx-5'>
    <div class='card musicCard text-center bg-dark text-white border-secondary mb-3'>
        <img class='card-img-top albumArt' src='<?php echo $album_art_url ?>' alt='Card image cap'>
        <div class='card-body'>
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
            <h6 class='card-title album'><?php echo $album_title ?></h6>
            <h6 class='card-subtitle artist'><?php echo $album_artist ?></h6>
        </div>
        <div class='card-footer row border-secondary align-items-center mx-0'>
            <div class='col-4 own'>
                <a role='button'>
                    <i id='ownIcon<?php echo $music_card_count ?>' class='fas fa-plus fa-lg own' data-toggle='popover' title='Own' data-content='Owned music' data-target='ownIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
            <div class='col-4 favourite'>
                <a role='button'>
                    <i id='favouriteIcon<?php echo $music_card_count ?>' class='far fa-heart fa-lg favourite' data-toggle='popover' title='Favourite' data-content='Favourited Music' data-target='favouriteIcon<?php echo $music_card_count ?>'></i>
                </a>
            </div>
            <div class='col-4'>
                <a href='#' class='btn styled_button'>View</a>
            </div>
        </div>
    </div>
</div>