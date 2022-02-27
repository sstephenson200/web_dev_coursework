<?php

session_start();

if(isset($_GET['artist'])){
    $artist = $_GET['artist'];
}

$active_filters = $_SESSION["active_filters"];

if($active_filters['artists']){

    if (in_array($artist, $active_filters['artists'])) {

        foreach($active_filters['artists'] as $key => $applied_artists){
    
            if($applied_artists == $artist) {
                unset($active_filters['artists'][$key]);
                $_SESSION['active_filters'] = $active_filters;
            }
            
        }
        
    }
}

echo '<script>window.location = "../../album_browse.php"</script>';

?>