<?php

$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $suppr_id = htmlspecialchars($_GET['id']);
    
    $suppr = $bdd->prepare('DELETE FROM topics WHERE id = ?');
    $suppr->execute(array($suppr_id));
    $supprcont = $bdd->prepare('DELETE FROM message WHERE id_sujet = ?');
    $supprcont->execute(array($suppr_id));
 
    header('Location: Accueil.php?notif=1');
    
}





?>
