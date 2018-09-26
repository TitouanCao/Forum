<?php

$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_GET['idmembre']) AND !empty($_GET['idmembre'])) {
    $suppr_id = htmlspecialchars($_GET['idmembre']);
    
    $suppr = $bdd->prepare('DELETE FROM espacemembre WHERE id = ?');
    $suppr->execute(array($suppr_id));
    
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $referer);
    
}

?>