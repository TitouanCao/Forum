<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: Espace_membre_connexion.php");

?>