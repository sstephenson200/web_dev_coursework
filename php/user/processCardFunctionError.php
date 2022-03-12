<?php

session_start();

$_SESSION['loginErrors'] = "Card features.";

echo "<script>window.location = '../../login.php'</script>";

?>