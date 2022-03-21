<?php

$base_url = "http://localhost/web_dev_coursework/api/";
$existing_album = false;
$existing_artist = false;
$existing_year = false;
$artist_id = null;
$year_id = null;
$art_id = null;
$album_id = null;
$genre_id = null;

session_start();

if(isset($_POST['addAlbum'])){

    //get required variables
    $title = urlencode(trim($_POST['albumTitle']));
    $artist = urlencode(trim($_POST['artist']));
    $art_url = urlencode(trim($_POST['art']));
    $year = urlencode(trim($_POST['year']));
    $tracks = $_POST['songs'];
    $tracks = explode(',',$tracks);
    $trackLengths = $_POST['lengths'];
    $trackLengths = explode(',',$trackLengths);
    $genres = $_POST['genres'];
    $genres = explode(',',$genres);
    $subgenres = $_POST['subgenres'];
    $subgenres = explode(',',$subgenres);

    //get optional variables
    $spotify_id = $_POST['spotifyID'];
    $rating = $_POST['rating'];

    //get all albums
    $album_endpoint = $base_url . "album/getAlbum/getAllAlbums.php";
    $album_resource = file_get_contents($album_endpoint);
    $album_data = json_decode($album_resource, true);

    //get all artists
    $artist_endpoint = $base_url . "album/getAlbum/getArtists.php";
    $artist_resource = file_get_contents($artist_endpoint);
    $artist_data = json_decode($artist_resource, true);

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

    //get all years
    $year_endpoint = $base_url . "album/getAlbum/getAllYears.php";
    $year_resource = file_get_contents($year_endpoint);
    $year_data = json_decode($year_resource, true);

    //check if album exists
    foreach($album_data as $album){
        if($album['album_title'] == $title and $album['artist_name'] == $artist){
            $existing_album = true;
            break;
        }
    }

    if($existing_album){
        $_SESSION['adminMessage'] = "Album exists.";
    } else {

        //check if track and tracklength are the same length
        if(count($tracks) != count($trackLengths)){
            $_SESSION['adminMessage'] = "Incorrect songs.";
            echo "<script>window.location = '../../../admin.php'</script>";
        }

        //check track lengths are in the correct format
        foreach($trackLengths as $length){
            if(!strpos($length, ":")){
                $_SESSION['adminMessage'] = "Song Length Format.";
                echo "<script>window.location = '../../../admin.php'</script>";
            }
        }

        //check if artist exists
        foreach($artist_data as $current_artist){
            if($current_artist[0] == $artist){
                //get artist id for existing artist
                $get_artist_endpoint = $base_url . "album/getAlbum/getArtistIDByName.php?artist_name=$artist";
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
            $create_artist_endpoint = $base_url . "album/addAlbum/createArtist.php?artist_name=$artist";
            $create_artist_resource = file_get_contents($create_artist_endpoint);
            $create_artist_data = json_decode($create_artist_resource, true);

            if($create_artist_data){
                if($create_artist_data['message'] == "Artist created."){
                    $get_artist_endpoint = $base_url . "album/getAlbum/getArtistIDByName.php?artist_name=$artist";
                    $get_artist_resource = file_get_contents($get_artist_endpoint);
                    $get_artist_data = json_decode($get_artist_resource, true);

                    if($get_artist_data){
                        $artist_id = $get_artist_data[0]['artist_id'];
                    }
                } else {
                    $_SESSION['adminMessage'] = "Error.";
                    echo "<script>window.location = '../../../admin.php'</script>";
                }
            }
            
        }

        //check if year exists
        foreach($year_data as $current_year){
            if($current_year[0] == $year){
                //get year id for existing year
                $get_year_endpoint = $base_url . "album/getAlbum/getYearIDByValue.php?year_value=$year";
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
            $create_year_endpoint = $base_url . "album/addAlbum/createYear.php?year_value=$year";
            $create_year_resource = file_get_contents($create_year_endpoint);
            $create_year_data = json_decode($create_year_resource, true);

            if($create_year_data){
                if($create_year_data['message'] == "Year created."){
                    $get_year_endpoint = $base_url . "album/getAlbum/getYearIDByValue.php?year_value=$year";
                    $get_year_resource = file_get_contents($get_year_endpoint);
                    $get_year_data = json_decode($get_year_resource, true);

                    if($get_year_data){
                        $year_id = $get_year_data[0]['year_value_id'];
                    }
                } else {
                    $_SESSION['adminMessage'] = "Error.";
                    echo "<script>window.location = '../../../admin.php'</script>";
                }
            }
            
        }

        //create art
        $create_art_endpoint = $base_url . "album/addAlbum/createArt.php?art_url=$art_url";
        $create_art_resource = file_get_contents($create_art_endpoint);
        $create_art_data = json_decode($create_art_resource, true);

        if($create_art_data){
            if($create_art_data['message'] == "Art created."){
                
                $art_id = $create_art_data['art_id'];
                
            } else {
                $_SESSION['adminMessage'] = "Error.";
                echo "<script>window.location = '../../../admin.php'</script>";
            }
        }

        //create album
        $create_album_endpoint = $base_url . "album/addAlbum/createAlbum.php?title=$title&art_id=$art_id&artist_id=$artist_id&year_id=$year_id&spotify_id=$spotify_id&album_rating=$rating";
        $create_album_resource = file_get_contents($create_album_endpoint);
        $create_album_data = json_decode($create_album_resource, true);

        if($create_album_data){
            if($create_album_data['message'] == "Album created."){
                $album_id = $create_album_data['album_id'];

                if($album_id){
                    $_SESSION['adminMessage'] = "Album added.";
                }
            } else {
                $_SESSION['adminMessage'] = "Error.";
                echo "<script>window.location = '../../../admin.php'</script>";
            }
        }

        
        //check if genre exists
        foreach($genres as $genre){
            $genre = urlencode(trim($genre));
            if(!in_array($genre, $genre_list)){
                //create genre
                $create_genre_endpoint = $base_url . "album/addAlbum/createGenre.php?genre=$genre";
                $create_genre_resource = file_get_contents($create_genre_endpoint);
                $create_genre_data = json_decode($create_genre_resource, true);

                if($create_genre_data){
                    if($create_genre_data['message'] != "Genre created."){
                        
                        $_SESSION['adminMessage'] = "Error.";
                        echo "<script>window.location = '../../../admin.php'</script>";
                        
                    }
                }
            } 
        }

        //add album_genre entries
        foreach($genres as $genre){
            //get genre_id
            $genre = urlencode(trim($genre));
            $get_genre_endpoint = $base_url . "album/getAlbum/getGenreIDByTitle.php?genre=$genre";
            $get_genre_resource = file_get_contents($get_genre_endpoint);
            $get_genre_data = json_decode($get_genre_resource, true);

            if($get_genre_data){
                $genre_id = $get_genre_data[0]['genre_id'];

                //add row to album_genre
                $album_genre_endpoint = $base_url . "album/addAlbum/addAlbumGenre.php?genre_id=$genre_id&album_id=$album_id";
                $album_genre_resource = file_get_contents($album_genre_endpoint);
                $album_genre_data = json_decode($album_genre_resource, true);

            } else {
                $_SESSION['adminMessage'] = "Error.";
                echo "<script>window.location = '../../../admin.php'</script>";
            } 
            
        }
        
        //check if subgenre exists
        foreach($subgenres as $subgenre){
            $subgenre = urlencode(trim($subgenre));
            if(!in_array($subgenre, $subgenre_list)){
                //create subgenre
                $create_subgenre_endpoint = $base_url . "album/addAlbum/createSubgenre.php?subgenre=$subgenre";
                $create_subgenre_resource = file_get_contents($create_subgenre_endpoint);
                $create_subgenre_data = json_decode($create_subgenre_resource, true);

                if($create_subgenre_data){
                    if($create_subgenre_data['message'] != "Subgenre created."){
                        
                        $_SESSION['adminMessage'] = "Error.";
                        echo "<script>window.location = '../../../admin.php'</script>";
                        
                    }
                }
            } 
        }

        //add album_subgenre entries
        foreach($subgenres as $subgenre){
            //get subgenre_id
            $subgenre = urlencode(trim($subgenre));
            $get_subgenre_endpoint = $base_url . "album/getAlbum/getSubgenreIDByTitle.php?subgenre=$subgenre";
            $get_subgenre_resource = file_get_contents($get_subgenre_endpoint);
            $get_subgenre_data = json_decode($get_subgenre_resource, true);

            if($get_subgenre_data){
                $subgenre_id = $get_subgenre_data[0]['subgenre_id'];

                //add row to album_subgenre
                $album_subgenre_endpoint = $base_url . "album/addAlbum/addAlbumSubgenre.php?subgenre_id=$subgenre_id&album_id=$album_id";
                $album_subgenre_resource = file_get_contents($album_subgenre_endpoint);
                $album_subgenre_data = json_decode($album_subgenre_resource, true);

            } else {
                $_SESSION['adminMessage'] = "Error.";
                echo "<script>window.location = '../../../admin.php'</script>";
            } 
            
        }

        //add album songs
        foreach (array_combine($tracks, $trackLengths) as $track => $length){
            $track = urlencode(trim($track));
            $length = trim($length);

            $song_endpoint = $base_url . "album/addAlbum/addTrack.php?album_id=$album_id&title=$track&length=$length";
            $song_resource = file_get_contents($song_endpoint);
            $song_data = json_decode($song_resource, true);
        }
    }

} else {
    $_SESSION['adminMessage'] = "Error.";
}

echo "<script>window.location = '../../../admin.php'</script>";

?>