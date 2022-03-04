<?php 

session_start();

function sortCommunity($communitySort, $array){
    switch($communitySort){
        case 'title':
            usort($array, 'community_name');
            break;
        case 'size':
            usort($array, 'MemberCount');
            break;
        default:
            break;
    }

    return $array;
}

function community_name($a, $b){
    return strcmp($a['community_name'], $b['community_name']);
}

function MemberCount($a, $b){
    return $a['MemberCount'] < $b['MemberCount'];
}

$communitySort = $_POST['communitySortFilter'];

if(!empty($_SESSION['filtered_community_data'])){
    $filtered_community_data = $_SESSION['filtered_community_data'];
    $filtered_community_data = sortCommunity($communitySort, $filtered_community_data);
    $_SESSION['filtered_community_data'] = $filtered_community_data;
} else {
    $community_data = $_SESSION["community_data"];
    $community_data = sortCommunity($communitySort, $community_data);
    $_SESSION['community_data'] = $community_data;
}

$_SESSION['community_sort_type'] = $communitySort;

echo '<script>window.location = "../../community_browse.php"</script>'

?>