<?php 

if(isset($_SESSION['deletedAlbumMessage'])){
    switch($_SESSION['deletedAlbumMessage']){ 
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

?>

<div id="deletedAlbumMessage" class="modal hide fade" role="dialog">
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
    $('#deletedAlbumMessage').modal('show');
});
</script>


<?php 
if(isset($_SESSION['deletedAlbumMessage'])) {

    if($_SESSION['deletedAlbumMessage'] == "Album deleted."){
        if(isset($_SESSION['album_data'])){
            unset($_SESSION['album_data']);
          }
        if(isset($_SESSION['filtered_data'])){
        unset($_SESSION['album_data']);
        }
    }

    unset($_SESSION['deletedAlbumMessage']);
}

?>