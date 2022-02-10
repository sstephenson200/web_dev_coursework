<?php

session_start();

if(!isset($_POST['width']) || !is_numeric($_POST['width']))
{
    exit("Invalid width value");
}

$_SESSION['width'] = $_POST['width'];

echo "Success";

?>