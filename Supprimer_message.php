<?php

$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $suppr_id = htmlspecialchars($_GET['id']);
    
    $suppr = $bdd->prepare('DELETE FROM message WHERE id = ?');
    $suppr->execute(array($suppr_id));
    
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $referer);
    
}

?>
