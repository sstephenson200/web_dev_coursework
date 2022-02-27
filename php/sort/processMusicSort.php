<?php 

session_start();

function sortMusic($musicSort, $array){
    switch($musicSort){
        case 'artist':
            usort($array, 'artist_name');
            break;
        case 'title':
            usort($array, 'album_title');
            break;
        case 'top500':
            usort($array, 'album_rating');
            break;
        case 'rating':
            usort($array, 'AverageRating');
            break;
        case 'year':
            usort($array, 'year_value');
            break;
        default:
            break;
    }

    return $array;
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

$musicSort = $_POST['musicSortFilter'];

if(!empty($_SESSION['filtered_data'])){
    $filtered_data = $_SESSION['filtered_data'];
    $filtered_data = sortMusic($musicSort, $filtered_data);
    $_SESSION['filtered_data'] = $filtered_data;
    console_log("Sorting");
    console_log($filtered_data);
} else {
    console_log("Album Data");
    $album_data = $_SESSION["album_data"];
    $album_data = sortMusic($musicSort, $album_data);
    $_SESSION['album_data'] = $album_data;
}


function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

$_SESSION['sort_type'] = $musicSort;

echo '<script>window.location = "../../album_browse.php"</script>'

?>