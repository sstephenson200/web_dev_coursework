<?php 

if(isset($_SESSION['albumMessage'])){
    switch($_SESSION['albumMessage']){ 
        case 'Incorrect songs.':
          $title = "Not a match";
          $body = "Please enter an equal number of songs and song lengths.";
          break; 
        case 'Song Length Format.':
          $title = "Track length format incorrect";
          $body = "Please enter track lengths as mm:ss format.";
          break;  
        case 'Incorrect password.':
          $title = "Password incorrect";
          $body = "Sorry, that password doesn't look right... Let's try that again.";
          break;
        case 'Delete Album.':
            $title = "You are about to delete this album!";
            $body = "Are you sure? Users will no longer be able to access this content.";
            break;
        case 'Album deleted.':
            $title = "You have deleted this album.";
            $body = "Users are no longer be able to access this content.";
            break;
        default:
            $title = "Awkward...";
            $body = "Something went wrong. Please try again later.";
            break;
    }
}

if(isset($_SESSION['albumDetails'])){
    $album_id = $_SESSION['albumDetails'];
}

?>

<div id="albumMessage" class="modal hide fade" role="dialog">
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
        <?php if($_SESSION['albumMessage'] == "Delete Album.") { ?>
          <form action="php/album/processDeleteAlbum.php" method="POST">
          <div class="form-group mb-3">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
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
    $('#albumMessage').modal('show');
});
</script>


<?php 
if(isset($_SESSION['albumMessage'])) {

    if($_SESSION['albumMessage'] == "Album deleted."){
        if(isset($_SESSION['album_data'])){
            unset($_SESSION['album_data']);
          }
        if(isset($_SESSION['filtered_data'])){
        unset($_SESSION['album_data']);
        }
    }

    unset($_SESSION['albumMessage']);
}
?>