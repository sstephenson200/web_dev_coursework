<?php 
    $favouriteFlag = false;
    $ownedFlag = false;

    if($favourite_data){
        foreach($favourite_data as $favourite){
            if($album_id == $favourite['album_id']) {
                $favouriteFlag = true;
                break;
            } 
        }
    }

    if($owned_data){
        foreach($owned_data as $owned){
            if($album_id == $owned['album_id']) {
                $ownedFlag = true;
                break;
            } 
        }
    }
?>