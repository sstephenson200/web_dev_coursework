<?php 

if(isset($_SESSION['signupErrors'])){
    switch($_SESSION['signupErrors']){
        case 'Username is not unique.':
            $title = "A popular name";
            $body = "Sorry! That username has already been taken. Please choose another.";
            break;
        case 'Email is not unique.':
            $title = "You from around here?";
            $body = "It looks like there's already an account with this email.";
            break;
        case 'Empty input.':
          $title = "Cat got your tongue?";
          $body = "Please fill in all fields in the Sign Up form to continue.";
          break;
        case 'Invalid email address.':
            $title = "Invalid email address";
            $body = "Please check the entered email address is correct.";
            break;
        case 'Invalid username.':
            $title = "Invalid username";
            $body = "Your username must contain only numbers and letters.";
            break;
        case 'Username length is invalid.':
            $title = "Username length";
            $body = "Please make sure your username is between 5 and 30 characters.";
            break;
        case 'Passwords not a match.':
            $title = "Not a pair";
            $body = "It doesn't look like your passwords are a match. Please try again.";
            break;
        case 'Password length is invalid.':
            $title = "Password length";
            $body = "Please make sure your password is between 5 and 30 characters.";
            break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="signupErrors" class="modal hide fade" role="dialog">
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
    $('#signupErrors').modal('show');
});
</script>


<?php 
if(isset($_SESSION['signupErrors'])) {
    unset($_SESSION['signupErrors']);
}
?>