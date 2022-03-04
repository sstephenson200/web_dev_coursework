<?php 

session_start();

function sortSearch($searchSort, $array){
    switch($searchSort){
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

$searchSort = $_POST['searchSortFilter'];

if(!empty($_SESSION['filtered_search_data'])){
    $filtered_search_data = $_SESSION['filtered_search_data'];
    $filtered_search_data = sortSearch($searchSort, $filtered_search_data);
    $_SESSION['filtered_search_data'] = $filtered_search_data;
} else {
    $search_data = $_SESSION["search_data"];
    $search_data = sortSearch($searchSort, $search_data);
    $_SESSION['search_data'] = $search_data;
}

$_SESSION['search_sort_type'] = $searchSort;

echo '<script>window.location = "../../search.php"</script>'

?>