<?php 

if(isset($_SESSION['postReview'])){
    switch($_SESSION['postReview']){
        case 'Review created.':
            $title = "Thanks for reviewing this album!";
            $body = "We've got your review and an administrator will be reviewing it shortly.";
            break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
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
?>