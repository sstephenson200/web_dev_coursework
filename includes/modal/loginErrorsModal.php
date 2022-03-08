<?php 

if(isset($_SESSION['loginErrors'])){
    switch($_SESSION['loginErrors']){
        case 'Email incorrect.':
            $title = "What's that again?";
            $body = "Sorry, we don't recognise your email address! Try signing up if you don't have an account yet.";
            break;
        case 'Password incorrect.':
            $title = "Something's not right";
            $body = "It looks like your password is wrong. Let's try that again.";
            break;
        case 'Empty input.':
          $title = "Cat got your tongue?";
          $body = "Please fill in all fields in the Login form to continue.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="loginErrors" class="modal hide fade" role="dialog">
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
    $('#loginErrors').modal('show');
});
</script>


<?php 
if(isset($_SESSION['loginErrors'])) {
    unset($_SESSION['loginErrors']);
}
?>