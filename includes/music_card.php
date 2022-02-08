<?php
"<div class='card musicCard text-center bg-dark text-white border-secondary mb-3'>
    <img class='card-img-top albumArt' src='$album_art_url' alt='Card image cap'>
    <div class='card-body'>
        <p>
            <i class='fas fa-star'></i>
            <i class='fas fa-star'></i>
            <i class='fas fa-star'></i>
            <i class='fas fa-star'></i>
            <i class='fas fa-star'></i>
        </p>
        <h6 class='card-title album'>$album_title</h6>
        <h6 class='card-subtitle artist'>$album_artist</h6>
    </div>
    <div class='card-footer row border-secondary align-items-center mx-0'>
        <div class='col-4 own'>
            <a role='button'>
                <i id='ownIcon' class='fas fa-plus fa-lg' data-toggle='popover' title='Own' data-content='Owned music'></i>
            </a>
        </div>
        <div class='col-4 favourite'>
            <a role='button'>
                <i id='favouriteIcon' class='far fa-heart fa-lg' data-toggle='popover' title='Favourite' data-content='Favourited Music'></i>
            </a>
        </div>
        <div class='col-4 view'>
            <a href='#' class='btn'>View</a>
        </div>
    </div>
</div>"
?>