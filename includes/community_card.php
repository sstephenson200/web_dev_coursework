<div class="community mx-3">
    <div class="card communityCard text-center bg-dark text-white border-secondary mb-3">
        <img class="card-img-top img-thumbnail communityArt h-50" src="<?php echo $community_art_url ?>" alt="Card image cap">
            <div class="card-body">
                <h6 class="card-title communityName"><?php echo $community_name ?></h6>
                <h6 class="card-text communityDescription"><?php echo $community_description ?> | <?php echo $community_members ?> fans </h6>
            </div>
            <div class="card-footer row border-secondary align-items-center mx-0">
                <div class="col-6">
                    <a role="button"
                    <?php if(!isset($_SESSION['userLoggedIn'])) {
                         echo "href='login.php'"; 
                         $_SESSION['loginErrors'] = "Card features.";
                        } 
                ?>>
                        <i id="joinIcon<?php echo $community_card_count ?>" class="fas fa-user-plus fa-lg join" data-toggle="popover" title="Join" data-content="Join this community" data-target='joinIcon<?php echo $community_card_count ?>'></i>
                    </a>
                </div>
                <div class="col-6 view">
                    <a href="#" class="btn styled_button">View</a>
                </div>
            </div>
    </div>
</div>