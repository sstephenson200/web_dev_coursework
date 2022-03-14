<div class="card reviewCard text-center bg-dark text-white border-secondary h-100 mb-3">
	<div class="card-body">
        <div class="row py-2">
            <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username == $username ) { ?>
            <div class="col-3 col-sm-2 offset-9 offset-sm-10">
                <a role='button px-1' href='php/review/processEditReview.php?album_id=<?php echo $album_id ?>&title=<?php echo $review_title ?>&text=<?php echo $review_body ?>&rating=<?php echo $review_rating?>' class='text-reset text-decoration-none'>
                    <i id='editIcon<?php echo $review_card_count ?>' class='fas fa-edit fa-lg edit' data-toggle='popover' title='Edit' data-content='Edit Content' data-target='editIcon<?php echo $review_card_count ?>'></i>
                </a>
                <a role='button px-1' href='php/review/confirmDeleteReview.php?album_id=<?php echo $album_id ?>' class='text-reset text-decoration-none'>
                    <i id='deleteIcon<?php echo $review_card_count ?>' class='far fa-trash-alt fa-lg delete' data-toggle='popover' title='Delete' data-content='Delete Content' data-target='deleteIcon<?php echo $review_card_count ?>'></i>
                </a>
            </div>
            <?php } ?>
            <?php if(isset($_SESSION['userLoggedIn']) and $logged_in_username != $username) { ?>
            <div class="col-1 col-sm-2 offset-11 offset-sm-10">
                <a role='button px-1'>
                    <i id='reportIcon<?php echo $review_card_count ?>' class='far fa-flag fa-lg report' data-toggle='popover' title='Report' data-content='Report Content' data-target='reportIcon<?php echo $review_card_count ?>'></i>
                </a>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12 col-md-5 col-lg-6 align-self-center">
                <img src="<?php echo $user_art ?>?random=<?php echo rand() ?>" class="rounded-circle reviewUserArt" width='200' height='200'/>
            </div>
        	<div class="col-12 col-md-7 col-lg-6">
                <div class="row d-flex justify-content-center">
                    <h4 class="card-title"><?php echo $review_title ?></h4>
                    <h4>
                        <?php 
                            for($i=0; $i<$review_rating; $i++){
                                echo " <i class='fas fa-star fa-sm'></i>";
                            }
                        ?>
                    <h4>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <h6><a role="button" href="user_profile.php?user_id=<?php echo $user_id ?>"><?php echo $username ?></a></h6>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <h6><?php echo date("d/m/Y", strtotime($review_date)); ?></h6>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-3">
                    <div class="col-12 col-sm-10">
                        <p class="text-wrap"><?php echo $review_body ?></p>
                    </div>
                </div>
        	</div>
	    </div>
	</div>
</div>