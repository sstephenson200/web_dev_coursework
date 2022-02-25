<?php 

session_start();

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

$musicSort = $_POST['musicSortFilter'];
$album_data = $_SESSION["album_data"];

switch($musicSort){
    case 'artist':
        usort($album_data, 'artist_name');
        break;
    case 'title':
        usort($album_data, 'album_title');
        break;
    case 'top500':
        usort($album_data, 'album_rating');
        break;
    case 'rating':
        usort($album_data, 'AverageRating');
        break;
    case 'year':
        usort($album_data, 'year_value');
        break;
    default:
        break;
}

function artist_name($a, $b) {
    return strcmp($a['artist_name'], $b['artist_name']);
}

function album_title($a, $b){
    return strcmp($a['album_title'], $b['album_title']);
}

function album_rating($a, $b){
    return $a['album_rating'] > $b['album_rating'];
}

function AverageRating($a, $b) {
    return $a['AverageRating'] < $b['AverageRating'];
}

function year_value($a, $b) {
    return strcmp($a['year_value'], $b['year_value']);
}

$_SESSION['album_data'] = $album_data;
$_SESSION['sort_type'] = $musicSort;

echo '<script>window.location = "../../album_browse.php" </script>'

?>