<?php

function checkAlbumFiltering($album, $active_filters) {

    $flag = true;

    if(!in_array($album['artist_name'], $active_filters['artists'])){
        $flag = false;
    }

    return $flag;

}

foreach($album_data as $album) { 

    $flag = checkAlbumFiltering($album, $active_filters);

    if($flag){
        array_push($filtered_data, $album);
    }

}

?>