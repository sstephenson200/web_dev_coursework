<?php 

if(isset($_SESSION['adminMessage'])){
    switch($_SESSION['adminMessage']){
        case 'Album exists.':
          $title = "This album already exists!";
          $body = "Sorry, an album already exists with this artist and title. Please double check your entry!";
          break; 
        case 'Incorrect songs.':
          $title = "Not a match";
          $body = "Please enter an equal number of songs and song lengths.";
          break; 
        case 'Song Length Format.':
          $title = "Track length format incorrect";
          $body = "Please enter track lengths as mm:ss format.";
          break; 
        case 'Album added.':
          $title = "You have created a new album";
          $body = "Nice one! Thanks for keeping the revolution up to date.";
          break; 
        case 'Incorrect password.':
          $title = "Password incorrect";
          $body = "Sorry, that password doesn't look right... Let's try that again.";
          break;
        case 'Delete account.':
          $title = "You are about to delete this account!";
          $body = "Are you sure? This user will no longer be able to access Pebble Revolution.";
          break;
        case 'Account deleted.':
          $title = "You have deleted a user account.";
          $body = "This user will no longer be able to access Pebble Revolution.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

if(isset($_SESSION['banUserDetails'])){
  $user_id = $_SESSION['banUserDetails'];
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
        <?php if($_SESSION['adminMessage'] == "Delete account.") { ?>
          <form action="php/user/processBanAccount.php" method="POST">
          <div class="form-group mb-3">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
            <label for="passwordConfirmBan">Password</label>
            <input type="password" class="form-control" id="passwordConfirmBan" name="passwordConfirmBan" placeholder="Password" required="required">
          </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmBan" class="btn btn-danger">Confirm Deletion</button>
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
    $('#adminMessage').modal('show');
});
</script>


<?php 
if(isset($_SESSION['adminMessage'])) {
  if($_SESSION['adminMessage'] == "Album added."){
    if(isset($_SESSION['album_data'])){
      unset($_SESSION['album_data']);
    }
    if(isset($_SESSION['filtered_data'])){
      unset($_SESSION['album_data']);
    }
  }
    unset($_SESSION['adminMessage']);
}

if(isset($_SESSION['banUserDetails'])){
  unset($_SESSION['banUserDetails']);
}

?>