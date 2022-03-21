<?php 

if(isset($_SESSION['postReview'])){
    switch($_SESSION['postReview']){
        case 'Review created.':
            $title = "Thanks for reviewing this album!";
            $body = "We've got your review and an administrator will be reviewing it shortly.";
            break;
        case 'Previous review.':
          $title = "You've already posted a review for this album";
          $body = "Why not share your thoughts on another album?";
          break;
        case 'Delete review.':
          $title = "You are about to delete this review.";
          $body = "Are you sure you want to proceed?";
          break;
        case 'Review deleted.':
          $title = "Your review has been deleted.";
          $body = "Be sure to post some more soon!";
          break;
        case 'Review updated.':
          $title = "Your review has been updated.";
          $body = "We've got your review and an administrator will be reviewing it shortly.";
          break;
        case 'Report review.':
          $title = "You are about to report this review.";
          $body = "Are you sure you want to proceed?";
          break;
        case 'Review reported.':
          $title = "You have reported a review.";
          $body = "Thanks for bringing this to our attention! An administrator will review it shortly for inappropriate content.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

if(isset($_SESSION['reviewDetails'])){
  $album_id = $_SESSION['reviewDetails'];
}

if(isset($_SESSION['reportDetails'])){
  $album_id = $_SESSION['reportDetails'][0];
  $user_id = $_SESSION['reportDetails'][1];
}

?>

<div id="postReview" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $title ?></h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?php echo $body ?></p>
      </div>
      <?php if($_SESSION['postReview'] == "Delete review.") { ?>
        <div class="modal-footer">
          <form action="php/review/deleteReview/processDeleteReview.php" method="POST">
            <div class="form-group">
              <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
              <button type="submit" name="delete" class="btn btn-danger">Confirm Deletion</button>
            </div>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      <?php } ?>
      <?php if($_SESSION['postReview'] == "Report review.") { ?>
        <div class="modal-footer">
          <form action="php/review/editReview/processReportReview.php" method="POST">
            <div class="form-group">
              <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
              <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
              <button type="submit" name="report" class="btn btn-danger">Report</button>
            </div>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
    $(window).on('load', function() {
    $('#postReview').modal('show');
});
</script>


<?php 
if(isset($_SESSION['postReview'])) {
    unset($_SESSION['postReview']);
}

if(isset($_SESSION['reviewDetails'])){
  unset($_SESSION['reviewDetails']);
}
?>