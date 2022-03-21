<?php 
    $communityFlag = false;

    if($joined_community_data){
        foreach($joined_community_data as $community){
            if($community_id == $community['community_id']) {
                $communityFlag = true;
                break;
            } 
        }
    }

?>