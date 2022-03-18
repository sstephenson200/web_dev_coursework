<?php 

$base_url = "http://localhost/web_dev_coursework/api/";

session_start();

$artist_unchanged = false;
$art_unchanged = false;
$year_unchanged = false;

$existing_artist = false;
$existing_artist = false;
$existing_year = false;

$location = $_SERVER['HTTP_REFERER'];

if(isset($_POST['confirmEdit'])){
    
    $album_id = $_POST['album_id'];
    $edited_title = urlencode(trim($_POST['albumTitle']));
    $edited_artist =  urlencode(trim($_POST['artist']));
    $edited_art =  urlencode(trim($_POST['art']));
    $edited_spotify_id =  urlencode(trim($_POST['spotifyID']));
    $edited_rating =  urlencode(trim($_POST['rating']));
    $edited_year =  urlencode(trim($_POST['year']));
    $edited_genres = $_POST['genres'];
    $edited_subgenres = $_POST['subgenres'];
    $edited_songs = $_POST['songs'];
    $edited_lengths = $_POST['lengths'];

    //get original album data
    $album_endpoint = $base_url . "album/getAlbumByID.php?album_id=$album_id";
    $album_resource = file_get_contents($album_endpoint);
    $album_data = json_decode($album_resource, true);

    $original_art = $album_data[0]['art_url'];
    $original_title = $album_data[0]['album_title'];
    $original_artist = $album_data[0]['artist_name'];
    $original_rating = $album_data[0]['AverageRating'];
    $original_spotify_id = $album_data[0]['spotify_id'];
    $original_year = $album_data[0]['year_value'];
    $original_genres = $album_data[0]['Genres'];
    $original_subgenres = $album_data[0]['Subgenres'];

    $songs_endpoint = $base_url . "album/getSongsByAlbumID.php?album_id=$album_id";
    $songs_resource = @file_get_contents($songs_endpoint);
    $songs_data = json_decode($songs_resource, true);

    $original_songs = array();
    $original_lengths = array();

    foreach($songs_data as $song){
        $song_title = $song['song_title'];
        $duration = $song['song_length'];

        $original_songs[] = $song_title;
        $original_lengths[] = $duration;
    }

    //get all artists
    $all_artist_endpoint = $base_url . "album/getArtists.php";
    $all_artist_resource = file_get_contents($all_artist_endpoint);
    $all_artist_data = json_decode($all_artist_resource, true);
    
    //compare artist
    if($original_artist == $edited_artist){
        $artist_unchanged = true;
    } else {
        //check if artist exists
        foreach($all_artist_data as $current_artist){
            if(urlencode($current_artist[0]) == $edited_artist){
                //get artist id for existing artist
                $get_artist_endpoint = $base_url . "album/getArtistIDByName.php?artist_name=$edited_artist";
                $get_artist_resource = file_get_contents($get_artist_endpoint);
                $get_artist_data = json_decode($get_artist_resource, true);

                if($get_artist_data){
                    $artist_id = $get_artist_data[0]['artist_id'];
                }

                $existing_artist = true;
                break;
            } 
        }

        //artist doesn't exist
        if(!$existing_artist){
            //create new artist
            $create_artist_endpoint = $base_url . "album/createArtist.php?artist_name=$edited_artist";
            $create_artist_resource = file_get_contents($create_artist_endpoint);
            $create_artist_data = json_decode($create_artist_resource, true);

            if($create_artist_data){
                if($create_artist_data['message'] == "Artist created."){
                    $get_artist_endpoint = $base_url . "album/getArtistIDByName.php?artist_name=$edited_artist";
                    $get_artist_resource = file_get_contents($get_artist_endpoint);
                    $get_artist_data = json_decode($get_artist_resource, true);

                    if($get_artist_data){
                        $artist_id = $get_artist_data[0]['artist_id'];
                    }

                } else {
                    $_SESSION['adminMessage'] = "Error.";
                    //echo "<script>window.location = '$location'</script>";
                }
            }
            
        }
    }

    //compare art
    if(urlencode($original_art) == $edited_art){
        $art_unchanged = true;
    } else {
        //get art_id
        $art = urlencode($original_art);
        $get_art_endpoint = $base_url . "album/getArtIDByURL.php?art_url=$art";
        $get_art_resource = file_get_contents($get_art_endpoint);
        $get_art_data = json_decode($get_art_resource, true);

        if($get_art_data){
            $art_id = $get_art_data[0]['art_id'];

            //update art_url
            $update_art_endpoint = $base_url . "album/updateArt.php?art_id=$art_id&art_url=$edited_art";
            $update_art_resource = file_get_contents($update_art_endpoint);
            $update_art_data = json_decode($update_art_resource, true);

        } else {
            $_SESSION['adminMessage'] = "Error.";
            //echo "<script>window.location = '$location'</script>";
        }
    }

    //compare year
    if($original_year == $edited_year){
        $year_unchanged = true;
    } else {
        echo "Need to make new year";
    }


} else {
    $_SESSION['albumMessage'] = "Error.";
}

//echo "<script>window.location = '$location'</script>";

?>