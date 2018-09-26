<?php

$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_GET['idmembre']) AND !empty($_GET['idmembre'])) {
    $grade = "Modérateur";
    $suppr_id = htmlspecialchars($_GET['idmembre']);
    
    $promo = $bdd->prepare('UPDATE espacemembre SET grade = ? WHERE id = ?');
    $promo->execute(array($grade, $_GET['idmembre']));
    
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $referer);
    
}

?>

