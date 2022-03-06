<?php 

if(isset($_SESSION['email_submission'])){
    switch($_SESSION['email_submission']){
        case 'Email added.':
            $title = "Thanks for joining the revolution!";
            $body = "You've signed up to our newsletter. We'll be sending you some great content ASAP!";
            break;
        case 'Email already exists.':
            $title = "Miss us?";
            $body = "You've already signed up to our newsletter with this email address. Don't worry, we'll contact you soon!";
            break;
        case 'Invalid email.':
          $title = "Is that an email address?";
          $body = "Sorry! That email address doesn't look valid. Please try again.";
          break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

?>

<div id="emailSubmission" class="modal hide fade" role="dialog">
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
    $('#emailSubmission').modal('show');
});
</script>


<?php 
if(isset($_SESSION['email_submission'])) {
    unset($_SESSION['email_submission']);
}
?>