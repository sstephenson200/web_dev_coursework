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
    $edited_genres = explode(',',$edited_genres);
    $edited_subgenres = $_POST['subgenres'];
    $edited_subgenres = explode(',',$edited_subgenres);
    $edited_songs = $_POST['songs'];
    $edited_songs = explode(',',$edited_songs);
    $edited_lengths = $_POST['lengths'];
    $edited_lengths = explode(',',$edited_lengths);

    //get original album data
    $album_endpoint = $base_url . "album/getAlbum/getAlbumByID.php?album_id=$album_id";
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

    $songs_endpoint = $base_url . "album/getAlbum/getSongsByAlbumID.php?album_id=$album_id";
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

    //check if track and tracklength are the same length
    if(count($edited_songs) != count($edited_lengths)){
        $_SESSION['albumMessage'] = "Incorrect songs.";
        echo "<script>window.location = '$location'</script>";
    }

    //check track lengths are in the correct format
    foreach($edited_lengths as $length){
        if(!strpos($length, ":")){
            $_SESSION['albumMessage'] = "Song Length Format.";
            echo "<script>window.location = '$location'</script>";
        }
    }

    //get all artists
    $all_artist_endpoint = $base_url . "album/getAlbum/getArtists.php";
    $all_artist_resource = file_get_contents($all_artist_endpoint);
    $all_artist_data = json_decode($all_artist_resource, true);
    
    //compare artist
    if($original_artist == $edited_artist){
        $artist_unchanged = true;
        //get artist id
        $get_artist_endpoint = $base_url . "album/getAlbum/getArtistIDByName.php?artist_name=$edited_artist";
        $get_artist_resource = file_get_contents($get_artist_endpoint);
        $get_artist_data = json_decode($get_artist_resource, true);

        if($get_artist_data){
            $artist_id = $get_artist_data[0]['artist_id'];
        }
    } else {
        //check if artist exists
        foreach($all_artist_data as $current_artist){
            if(urlencode($current_artist[0]) == $edited_artist){
                //get artist id for existing artist
                $get_artist_endpoint = $base_url . "album/getAlbum/getArtistIDByName.php?artist_name=$edited_artist";
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
            $create_artist_endpoint = $base_url . "album/addAlbum/createArtist.php?artist_name=$edited_artist";
            $create_artist_resource = file_get_contents($create_artist_endpoint);
            $create_artist_data = json_decode($create_artist_resource, true);

            if($create_artist_data){
                if($create_artist_data['message'] == "Artist created."){
                    $get_artist_endpoint = $base_url . "album/getAlbum/getArtistIDByName.php?artist_name=$edited_artist";
                    $get_artist_resource = file_get_contents($get_artist_endpoint);
                    $get_artist_data = json_decode($get_artist_resource, true);

                    if($get_artist_data){
                        $artist_id = $get_artist_data[0]['artist_id'];
                    }

                } else {
                    $_SESSION['albumMessage'] = "Error.";
                    echo "<script>window.location = '$location'</script>";
                }
            }
            
        }
    }

    //compare art
    if(urlencode($original_art) == $edited_art){
        $art_unchanged = true;
        $art = urlencode($original_art);
        $get_art_endpoint = $base_url . "album/getAlbum/getArtIDByURL.php?art_url=$art";
        $get_art_resource = file_get_contents($get_art_endpoint);
        $get_art_data = json_decode($get_art_resource, true);

        if($get_art_data){
            $art_id = $get_art_data[0]['art_id'];
        }
    } else {
        //get art_id
        $art = urlencode($original_art);
        $get_art_endpoint = $base_url . "album/getAlbum/getArtIDByURL.php?art_url=$art";
        $get_art_resource = file_get_contents($get_art_endpoint);
        $get_art_data = json_decode($get_art_resource, true);

        if($get_art_data){
            $art_id = $get_art_data[0]['art_id'];

            //update art_url
            $update_art_endpoint = $base_url . "album/editAlbum/updateArt.php?art_id=$art_id&art_url=$edited_art";
            $update_art_resource = file_get_contents($update_art_endpoint);
            $update_art_data = json_decode($update_art_resource, true);

        } else {
            $_SESSION['albumMessage'] = "Error.";
            echo "<script>window.location = '$location'</script>";
        }
    }

    //get all year data
    $year_endpoint = $base_url . "album/getAlbum/getAllYears.php";
    $year_resource = file_get_contents($year_endpoint);
    $year_data = json_decode($year_resource, true);

    //compare year
    if($original_year == $edited_year){
        $year_unchanged = true;
        $get_year_endpoint = $base_url . "album/getAlbum/getYearIDByValue.php?year_value=$original_year";
        $get_year_resource = file_get_contents($get_year_endpoint);
        $get_year_data = json_decode($get_year_resource, true);

        if($get_year_data){
            $year_id = $get_year_data[0]['year_value_id'];
        }
    } else {
        //check if year exists
        foreach($year_data as $current_year){
            if($current_year[0] == $edited_year){
                //get artist id for existing artist
                $get_year_endpoint = $base_url . "album/getAlbum/getYearIDByValue.php?year_value=$edited_year";
                $get_year_resource = file_get_contents($get_year_endpoint);
                $get_year_data = json_decode($get_year_resource, true);

                if($get_year_data){
                    $year_id = $get_year_data[0]['year_value_id'];
                }

                $existing_year = true;
                break;
            } 
        }

        //year doesn't exist
        if(!$existing_year){
            //create new year
            $create_year_endpoint = $base_url . "album/addAlbum/createYear.php?year_value=$edited_year";
            $create_year_resource = file_get_contents($create_year_endpoint);
            $create_year_data = json_decode($create_year_resource, true);

            if($create_year_data){
                if($create_year_data['message'] == "Year created."){
                    $get_year_endpoint = $base_url . "album/getAlbum/getYearIDByValue.php?year_value=$edited_year";
                    $get_year_resource = file_get_contents($get_year_endpoint);
                    $get_year_data = json_decode($get_year_resource, true);

                    if($get_year_data){
                        $year_id = $get_year_data[0]['year_value_id'];
                    }
                } else {
                    $_SESSION['albumMessage'] = "Error.";
                    echo "<script>window.location = '$location'</script>";
                }
            }
            
        }
    }

    //edit album
    $edit_album_endpoint = $base_url . "album/editAlbum/updateAlbum.php?album_id=$album_id&title=$edited_title&artist_id=$artist_id&art_id=$art_id&spotify_id=$edited_spotify_id&rating=$edited_rating&year_id=$year_id";
    $edit_album_resource = file_get_contents($edit_album_endpoint);
    $edit_album_data = json_decode($edit_album_resource, true);

    if($edit_album_data){
        if($edit_album_data['message'] == "Album updated."){
            $_SESSION['albumMessage'] = "Album updated.";
            
        } else {
            $_SESSION['albumMessage'] = "Error.";
            echo "<script>window.location = '$location'</script>";
        }
    }

    //get all genres
    $genre_endpoint = $base_url . "album/getAlbum/getGenres.php";
    $genre_resource = file_get_contents($genre_endpoint);
    $genre_data = json_decode($genre_resource, true);
    $genre_list = [];

    foreach($genre_data as $genre_block){
        foreach($genre_block as $genre){
            $genre_list[] = $genre;
        }
    }

    //process newly added genres
    foreach($edited_genres as $genre){
        $genre = urlencode(trim($genre));
        if(!in_array($genre, $original_genres)){
        
            //check if genre exists
            if(!in_array($genre, $genre_list)){
                //create genre
                $create_genre_endpoint = $base_url . "album/addAlbum/createGenre.php?genre=$genre";
                $create_genre_resource = file_get_contents($create_genre_endpoint);
                $create_genre_data = json_decode($create_genre_resource, true);

                if($create_genre_data){
                    if($create_genre_data['message'] != "Genre created."){
                        
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    }
                }
            } 

            //get genre_id
            $get_genre_endpoint = $base_url . "album/getAlbum/getGenreIDByTitle.php?genre=$genre";
            $get_genre_resource = file_get_contents($get_genre_endpoint);
            $get_genre_data = json_decode($get_genre_resource, true);

            if($get_genre_data){
                $genre_id = $get_genre_data[0]['genre_id'];

                //add album_genre entries
                $album_genre_endpoint = $base_url . "album/addAlbum/addAlbumGenre.php?genre_id=$genre_id&album_id=$album_id";
                $album_genre_resource = file_get_contents($album_genre_endpoint);
                $album_genre_data = json_decode($album_genre_resource, true);

            } else {
                $_SESSION['albumMessage'] = "Error.";
                echo "<script>window.location = '$location'</script>";
            } 
            
        }
    }

    //delete removed genres
    foreach($original_genres as $genre){
        $genre = urlencode(trim($genre));
        if(!in_array($genre, $edited_genres)){

            //get genre_id
            $get_genre_endpoint = $base_url . "album/getAlbum/getGenreIDByTitle.php?genre=$genre";
            $get_genre_resource = file_get_contents($get_genre_endpoint);
            $get_genre_data = json_decode($get_genre_resource, true);

            if($get_genre_data){
                $genre_id = $get_genre_data[0]['genre_id'];

                //delete from genre_album
                $delete_genre_endpoint = $base_url . "album/deleteAlbum/deleteAlbumGenre.php?genre_id=$genre_id&album_id=$album_id";
                $delete_genre_resource = file_get_contents($delete_genre_endpoint);
                $delete_genre_data = json_decode($delete_genre_resource, true);
            }
        }
    }

    //get all subgenres
    $subgenre_endpoint = $base_url . "album/getAlbum/getSubgenres.php";
    $subgenre_resource = file_get_contents($subgenre_endpoint);
    $subgenre_data = json_decode($subgenre_resource, true);
    $subgenre_list = [];

    foreach($subgenre_data as $subgenre_block){
        foreach($subgenre_block as $subgenre){
            $subgenre_list[] = $subgenre;
        }
    }

    //process newly added subgenres
    foreach($edited_subgenres as $subgenre){
        $subgenre = urlencode(trim($subgenre));
        if(!in_array($subgenre, $original_subgenres)){
        
            //check if subgenre exists
            if(!in_array($subgenre, $subgenre_list)){
                //create subgenre
                $create_subgenre_endpoint = $base_url . "album/addAlbum/createSubgenre.php?subgenre=$subgenre";
                $create_subgenre_resource = file_get_contents($create_subgenre_endpoint);
                $create_subgenre_data = json_decode($create_subgenre_resource, true);

                if($create_subgenre_data){
                    if($create_subgenre_data['message'] != "Subgenre created."){
                        
                        $_SESSION['albumMessage'] = "Error.";
                        echo "<script>window.location = '$location'</script>";
                    }
                }
            } 

            //get subgenre_id
            $get_subgenre_endpoint = $base_url . "album/getAlbum/getSubgenreIDByTitle.php?subgenre=$subgenre";
            $get_subgenre_resource = file_get_contents($get_subgenre_endpoint);
            $get_subgenre_data = json_decode($get_subgenre_resource, true);

            if($get_subgenre_data){
                $subgenre_id = $get_subgenre_data[0]['subgenre_id'];

                //add album_subgenre entries
                $album_subgenre_endpoint = $base_url . "album/addAlbum/addAlbumSubgenre.php?subgenre_id=$subgenre_id&album_id=$album_id";
                $album_subgenre_resource = file_get_contents($album_subgenre_endpoint);
                $album_subgenre_data = json_decode($album_subgenre_resource, true);

            } else {
                $_SESSION['albumMessage'] = "Error.";
                echo "<script>window.location = '$location'</script>";
            } 
            
        }
    }

    //delete removed subgenres
    foreach($original_subgenres as $subgenre){
        $subgenre = urlencode(trim($subgenre));
        if(!in_array($subgenre, $edited_subgenres)){

            //get subgenre_id
            $get_subgenre_endpoint = $base_url . "album/getAlbum/getSubgenreIDByTitle.php?subgenre=$subgenre";
            $get_subgenre_resource = file_get_contents($get_subgenre_endpoint);
            $get_subgenre_data = json_decode($get_subgenre_resource, true);

            if($get_subgenre_data){
                $subgenre_id = $get_subgenre_data[0]['subgenre_id'];

                //delete from subgenre_album
                $delete_subgenre_endpoint = $base_url . "album/deleteAlbum/deleteAlbumSubgenre.php?subgenre_id=$subgenre_id&album_id=$album_id";
                $delete_subgenre_resource = file_get_contents($delete_subgenre_endpoint);
                $delete_subgenre_data = json_decode($delete_subgenre_resource, true);
            }
        }
    }

    //process newly added songs
    foreach($edited_songs as $title){
        $song_title = trim($title);
        $index = array_search($title, $edited_songs);
        $length = $edited_lengths[$index];
        $length = trim($length);

        if(in_array($song_title, $original_songs)){
            //get original length
            $song_title = urlencode($title);
            $length_endpoint = $base_url . "album/getAlbum/getSongLength.php?album_id=$album_id&song_title=$song_title";
            $length_resource = file_get_contents($length_endpoint);
            $length_data = json_decode($length_resource, true);

            if($length_data){
                $original_length = $length_data[0]['song_length'];

                if($original_length != $length){
                    //update song length
                    $update_length_endpoint = $base_url . "album/editAlbum/updateSongLength.php?album_id=$album_id&song_title=$song_title&song_length=$length";
                    $update_length_resource = file_get_contents($update_length_endpoint);
                    $update_length_data = json_decode($update_length_resource, true);
                }
            } else {
                $_SESSION['albumMessage'] = "Error.";
                echo "<script>window.location = '$location'</script>";
            }
        } else {
            //add song
            $song_title = urlencode(trim($song_title));
            $song_length = trim($length);
            $song_endpoint = $base_url . "album/addAlbum/addTrack.php?album_id=$album_id&title=$song_title&length=$song_length";
            $song_resource = file_get_contents($song_endpoint);
            $song_data = json_decode($song_resource, true);
        }
    }

    //delete removed songs
    foreach($original_songs as $song){
        $song_title = trim($song);
            
        if(!in_array($song_title, $edited_songs)){
            $song_title = urlencode($song_title);
    
            //get song_id
            $get_song_endpoint = $base_url . "album/getAlbum/getSongIDByTitle.php?album_id=$album_id&song_title=$song_title";
            $get_song_resource = file_get_contents($get_song_endpoint);
            $get_song_data = json_decode($get_song_resource, true);
    
            if($get_song_data){
                $song_id = $get_song_data[0]['song_id'];

                //delete song
                $delete_song_endpoint = $base_url . "album/deleteAlbum/deleteTrack.php?song_id=$song_id";
                $delete_song_resource = file_get_contents($delete_song_endpoint);
                $delete_song_data = json_decode($delete_song_resource, true);
            } else {
                $_SESSION['albumMessage'] = "Error.";
                echo "<script>window.location = '$location'</script>";
            }
        }
    }


} else {
    $_SESSION['albumMessage'] = "Error.";
}

echo "<script>window.location = '$location'</script>";

?>