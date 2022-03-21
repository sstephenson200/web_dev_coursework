<?php 

if(isset($_SESSION['editReview'])){
    $title = "Edit Review";
}

if(isset($_SESSION['editDetails'])){
    $album_id = $_SESSION['editDetails'][0];
    $review_title = $_SESSION['editDetails'][1];
    $text = $_SESSION['editDetails'][2];
    $review_rating = $_SESSION['editDetails'][3];
}

?>

<div id="editReview" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $title ?></h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="php/review/editReview/editReview.php" method="POST">
            <div class="row d-flex justify-content-center">
                <div class="col-6 col-sm-8">
                    <div class="form-group mb-3">
                        <label for="reviewTitle">Title</label>
                        <input type="text" class="form-control" id="reviewTitle" name="reviewTitle" maxlength="30" placeholder="Review Title" value="<?php echo $review_title ?>" required="required">
                        <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
                    </div>
                </div>
                <div class="col-4 col-sm-2">
                    <label for="reviewRating">Rating</label>
                    <select class="form-select" aria-label="ratingSelector" id="reviewRating" name="reviewRating">
                        <option value="5" <?php if($review_rating == '5') { echo "selected";} ?>>5</option>
                        <option value="4" <?php if($review_rating == '4') { echo "selected";} ?>>4</option>
                        <option value="3" <?php if($review_rating == '3') { echo "selected";} ?>>3</option>
                        <option value="2" <?php if($review_rating == '2') { echo "selected";} ?>>2</option>
                        <option value="1" <?php if($review_rating == '1') { echo "selected";} ?>>1</option>
                    </select>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-10">
                    <div class="form-group">
                        <label for="reviewText">Your Review</label>
                        <textarea class="form-control" id="reviewText" name="reviewText" rows="3" maxlength="250" placeholder="Please enter your review..." required="required"><?php echo $text?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" name="edit" class="btn styled_button">Save Changes</button>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(window).on('load', function() {
    $('#editReview').modal('show');
});
</script>


<?php 
if(isset($_SESSION['editReview'])) {
    unset($_SESSION['editReview']);
}

if(isset($_SESSION['editDetails'])) {
    unset($_SESSION['editDetails']);
}
?>