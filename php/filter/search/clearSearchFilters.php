<?php

session_start();

if(isset($_SESSION['search_filters'])){
    unset($_SESSION['search_filters']);
    unset($_SESSION['filtered_search_data']);
}

echo '<script>window.location = "../../../search.php"</script>';

?>