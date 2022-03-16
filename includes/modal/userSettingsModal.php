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
        case 'Invalid email.':
          $title = "Invalid email address";
          $body = "Please check the entered email address is correct.";
          break;
        case 'Email in use.':
          $title = "You from around here?";
          $body = "It looks like there's already an account with this email.";
          break;
        case 'Reset email.':
          $title = "You are about to reset your email address";
          $body = "Are you sure? You'll not be able to access your account with your previous email address.";
          break;
        case 'Email updated.':
          $title = "You've updated your email";
          $body = "You can now log in with your new email and we'll contact you with your new email address from now on.";
          break;
        case 'Reset username.':
          $title = "You are about to reset your username";
          $body = "Are you sure? This will change on your profile and all previous reviews.";
          break;
        case 'Username length.':
          $title = "Username length";
          $body = "Please make sure your username is between 5 and 30 characters.";
          break;
        case 'Username in use.':
          $title = "A popular name";
          $body = "Sorry! That username has already been taken. Please choose another.";
          break;
        case 'Username updated.':
          $title = "You've updated your username";
          $body = "Your new username can now be seen on your profile and reviews.";
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

if(isset($_SESSION['emailResetDetails'])){
  $email = $_SESSION['emailResetDetails'];
} else if(isset($_SESSION['usernameResetDetails'])){
  $username = $_SESSION['usernameResetDetails'];
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
      <?php } else if($_SESSION['userSettingsMessage'] == "Reset email.") { ?>
        <form action="php/user/processResetEmail.php" method="POST">
          <div class="form-group mb-3">
            <input type="hidden" name="email" value="<?php echo $email ?>" />
            <label for="passwordConfirmEmailReset">Password</label>
            <input type="password" class="form-control" id="passwordConfirmEmailReset" name="passwordConfirmEmailReset" placeholder="Password" required="required">
          </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmEmailReset" class="btn btn-danger">Confirm Email Reset</button>
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
          <?php } else if($_SESSION['userSettingsMessage'] == "Reset username.") { ?>
        <form action="php/user/processResetUsername.php" method="POST">
          <div class="form-group mb-3">
            <input type="hidden" name="username" value="<?php echo $username ?>" />
            <label for="passwordConfirmUsernameReset">Password</label>
            <input type="password" class="form-control" id="passwordConfirmUsernameReset" name="passwordConfirmUsernameReset" placeholder="Password" required="required">
          </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmUsernameReset" class="btn btn-danger">Confirm Username Reset</button>
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

if(isset($_SESSION['emailResetDetails'])) {
  unset($_SESSION['emailResetDetails']);
}

if(isset($_SESSION['usernameResetDetails'])) {
  unset($_SESSION['usernameResetDetails']);
}
?>