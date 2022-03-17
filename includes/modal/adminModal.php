<?php 

if(isset($_SESSION['adminMessage'])){
    switch($_SESSION['adminMessage']){        
        case 'Incorrect password.':
          $title = "Password incorrect";
          $body = "Sorry, that password doesn't look right... Let's try that again.";
          break;
        case 'Delete account.':
          $title = "You are about to delete this account!";
          $body = "Are you sure? This user will no longer be able to access Pebble Revolution.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="adminMessage" class="modal hide fade" role="dialog">
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
    $('#adminMessage').modal('show');
});
</script>


<?php 
if(isset($_SESSION['adminMessage'])) {
    unset($_SESSION['adminMessage']);
}

?>