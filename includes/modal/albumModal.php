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
        case 'Edit Album.':
            $title = "Edit Album";
            break;
        case 'Album updated.':
          $title = "Album updated.";
          $body = "Thanks for updating this album!";
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

$tracks = array();
$lengths = array();

foreach($songs_data as $song){
  $song_title = $song['song_title'];
  $duration = $song['song_length'];

  $tracks[] = $song_title;
  $lengths[] = $duration;
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
        <?php if($_SESSION['albumMessage'] == "Edit Album.") { ?>
          <form action="php/album/editAlbum/processEditAlbum.php" method="POST">
            <div class="col-12">
                <div class="form-group mb-3">
                <input type="hidden" name="album_id" value="<?php echo $album_id ?>" />
                <label for="albumTitle">Album Title</label>
                <input type="text" class="form-control" id="albumTitle" name="albumTitle" maxlength="30" placeholder="Album Title" value="<?php echo $album_title ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="artist">Artist</label>
                <input type="text" class="form-control" id="artist" name="artist" maxlength="30" placeholder="Artist" value="<?php echo $album_artist ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="art">Art URL</label>
                <input type="url" class="form-control" id="art" name="art" placeholder="Art URL" value="<?php echo $album_art_url ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="spotifyID">Spotify ID</label>
                <input type="text" class="form-control" id="spotifyID" name="spotifyID" value="<?php echo $spotify_id ?>" placeholder="Spotify ID">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="rating">Album Rating</label>
                <input type="text" class="form-control" id="rating" maxlength="3" name="rating" value="<?php echo $rating ?>" placeholder="Album Rating">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="year">Year</label>
                <input type="text" class="form-control" id="year" name="year" maxlength="4" placeholder="Year Published" value="<?php echo $year ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="genres">Genres</label>
                <input type="text" class="form-control" id="genres" name="genres" placeholder="Genre1, Genre2, Genre3" value="<?php echo implode(',',$genres) ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="subgenres">Subgenres</label>
                <input type="text" class="form-control" id="subgenres" name="subgenres" placeholder="Subgenre1, Subgenre2, Subgenre3" value="<?php echo implode(',',$subgenres) ?>" required="required">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="songs">Album Tracks</label>
                <textarea class="form-control" id="songs" name="songs" placeholder="Track1, Track2, Track3" rows="3" required="required"><?php echo implode(',',$tracks) ?></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3">
                <label for="lengths">Track Lengths</label>
                <textarea class="form-control" id="lengths" name="lengths" placeholder="TrackLength1, TrackLength2, TrackLength3" rows="3" required="required"><?php echo implode(',',$lengths) ?></textarea>
                </div>
            </div>
        </div>
            <div class="modal-footer">
              <div>
                <button type="submit" name="confirmEdit" class="btn styled_button">Save Changes</button>
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        <?php } else {?> 
        <p><?php echo $body ?></p>
        <?php if($_SESSION['albumMessage'] == "Delete Album.") { ?>
          <form action="php/album/deleteAlbum/processDeleteAlbum.php" method="POST">
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

    if( $_SESSION['albumMessage'] == "Album updated."){
        if(isset($_SESSION['album_data'])){
            unset($_SESSION['album_data']);
          }
        if(isset($_SESSION['filtered_data'])){
        unset($_SESSION['album_data']);
        }
    }

    unset($_SESSION['albumMessage']);
}

if(isset($_SESSION['albumDetails'])){
  unset($_SESSION['albumDetails']);
}
?>