<div class="card reviewCard text-center bg-dark text-white border-secondary h-100 mb-3">
	<div class="card-body">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-6 align-self-center">
                <img src="<?php echo $user_art ?>?random=<?php echo rand() ?>" class="rounded-circle reviewUserArt"/>
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
                        <h6><?php echo $username ?></h6>
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