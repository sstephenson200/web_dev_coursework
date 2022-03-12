<?php 
    $communityFlag = false;

    if($joined_community_data){
        foreach($joined_community_data as $community){
            if($community_name == $community['community_name']) {
                $communityFlag = true;
                break;
            } 
        }
    }

?>