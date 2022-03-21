<?php

session_start();

$_SESSION['albumMessage'] = "Edit Album.";

$location = $_SERVER['HTTP_REFERER'];
echo "<script>window.location = '$location'</script>";

?>