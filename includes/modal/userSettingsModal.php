<?php 

if(isset($_SESSION['userSettingsMessage'])){
    switch($_SESSION['userSettingsMessage']){        
        case 'Profile updated.':
          $title = "Profile information updated.";
          $body = "Nice one! Looks like your profile is up to date.";
          break;
        case 'Contact permissions updated.':
          $title = "Email preferences updated";
          $body = "Looks like we're on the same page regarding the amount of emails you receive.";
          break;
        case 'Invalid password length.':
          $title = "Password length";
          $body = "Please make sure your password is between 5 and 30 characters.";
          break;
        case 'Incorrect password.':
          $title = "Password incorrect";
          $body = "Sorry, that password doesn't look right... Let's try that again.";
          break;
        case 'Passwords not a match.':
          $title = "Not a pair";
          $body = "It doesn't look like your passwords are a match. Please try again.";
          break;
        case 'Password updated.':
          $title = "You've updated your password";
          $body = "You can now log in with your new password.";
          break;
        case 'Delete account.':
          $title = "You are about to delete your account!";
          $body = "Are you sure? You won't be able to recover this account or create a new account with this email address.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="userSettingsMessage" class="modal hide fade" role="dialog">
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
        <?php if($_SESSION['userSettingsMessage'] == "Delete account.") { ?>
          <form action="php/user/processDeleteAccount.php" method="POST">
          <div class="form-group mb-3">
            <label for="passwordConfirmDelete">Password</label>
            <input type="password" class="form-control" id="passwordConfirmDelete" name="passwordConfirmDelete" placeholder="Password" required="required">
          </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmDelete" class="btn btn-danger">Confirm Deletion</button>
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
    $('#userSettingsMessage').modal('show');
});
</script>


<?php 
if(isset($_SESSION['userSettingsMessage'])) {
    unset($_SESSION['userSettingsMessage']);
}
?>