<?php

session_start();

if(isset($_SESSION['active_filters'])){
    unset($_SESSION['active_filters']);
}

echo '<script>window.location = "../../album_browse.php"</script>';

?>