<?php

session_start();

#checks if array contains item
function check_item_unique ($item, $array) {

    if (in_array($item, $array) and !is_null($item)) {
        return true;
    } else {
        return false;
    }
}

$artist = $_POST['artistSelector'];

$active_filters = $_SESSION["active_filters"];

if(!check_item_unique($artist,$active_filters['artists'])) {
    array_push($active_filters['artists'], $artist);
}

$_SESSION['active_filters'] = $active_filters;

echo '<script>window.location = "../../album_browse.php"</script>';

?>