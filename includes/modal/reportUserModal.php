<?php 

if(isset($_SESSION['reportUser'])){
    switch($_SESSION['reportUser']){
        case 'Report user.':
            $title = "You are about to delete this review.";
            $body = "Are you sure you want to proceed?";
            break;
        case 'Already reported.':
            $title = "You've already reported this user.";
            $body = "We're still reviewing your report and will action as soon as possible.";
            break;
        case 'Reported.':
            $title = "You have reported this user.";
            $body = "Thanks for bringing this to our attention! An administrator will review it shortly for inappropriate content.";
            break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

if(isset($_SESSION['reportUserDetails'])){
  $user_id = $_SESSION['reportUserDetails'];
}

?>

<div id="reportUser" class="modal hide fade" role="dialog">
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
        <?php if($_SESSION['reportUser'] == "Report user.") { ?>
          <form action="php/user/processReportUser.php" method="POST">
          <div class="form-group mb-3">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
            <label for="reportReason">Reason For Report</label>
            <input type="text" class="form-control" id="reportReason" name="reportReason" placeholder="Reason for report..." required="required">
          </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmReport" class="btn btn-danger">Report User</button>
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
      <?php } else { ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
    $(window).on('load', function() {
    $('#reportUser').modal('show');
});
</script>


<?php 
if(isset($_SESSION['reportUser'])) {
    unset($_SESSION['reportUser']);
}

if(isset($_SESSION['reportUserDetails'])){
  unset($_SESSION['reportUserDetails']);
}
?>