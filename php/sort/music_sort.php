<?php 

if(isset($_POST['musicSortFilter'])){

$sort = $_POST['musicSortFilter'];

switch($sort){
    case 'artist':
        usort($album_data, 'artist_name');
        break;
    default:
        break;
}


}

?>