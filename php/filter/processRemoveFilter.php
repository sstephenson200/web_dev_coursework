<?php

session_start();

$artist = $_POST['removeArtist'];

echo $artist;

$active_filters = $_SESSION["active_filters"];

$active_filters = array_diff($active_filters, array($artist));

$_SESSION['active_filters'] = $active_filters;

//echo '<script>window.location = "../../album_browse.php"</script>';

?>