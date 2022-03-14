<?php 

if(isset($_SESSION['passwordResetMessage'])){
    switch($_SESSION['passwordResetMessage']){
        case 'Updated.':
            $title = "Password Updated";
            $body = "Please check your email for your new password. Be sure to change it ASAP!";
            break;
        case 'Invalid email.':
          $title = "Is that an email address?";
          $body = "Sorry! That email address doesn't look valid. Please try again.";
          break;
        case 'Deleted account.':
          $title = "No entry";
          $body = "This account is no longer active and cannot be accessed.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="passwordReset" class="modal hide fade" role="dialog">
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
    </div>
  </div>
</div>

<script>
    $(window).on('load', function() {
    $('#passwordReset').modal('show');
});
</script>


<?php 
if(isset($_SESSION['passwordResetMessage'])) {
    unset($_SESSION['passwordResetMessage']);
}
?>