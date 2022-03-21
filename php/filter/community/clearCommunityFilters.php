<?php

session_start();

if(isset($_SESSION['community_filters'])){
    unset($_SESSION['community_filters']);
    unset($_SESSION['filtered_community_data']);
}

echo '<script>window.location = "../../../community_browse.php"</script>';

?>