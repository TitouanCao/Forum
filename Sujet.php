<?php 
require('fonction_forum.php');
include('menu.php');
require_once("jbbcode/JBBCode/Parser.php");
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
}

if(isset($_GET['titre'], $_GET['id']) AND !empty($_GET['titre']) AND !empty($_GET['id'])) {
    $get_titre = htmlspecialchars($_GET['titre']);
    $get_id = htmlspecialchars($_GET['id']);
    

    
    $titre_original = $bdd->prepare('SELECT sujet FROM topics WHERE id = ?');
    $titre_original->execute(array($get_id));
    $titre_original = $titre_original->fetch();
    $titre_original = $titre_original['sujet'];
    
    $parser = new JBBCode\Parser();
    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
    
    
    if($get_titre == $titre_original) {
        
        $topic = $bdd->prepare('SELECT * FROM topics WHERE id = ?');
        $topic->execute(array($get_id));
        $topic = $topic->fetch();
        
        if(isset($_POST['sujet_reponse_submit'], $_POST['sujet_reponse'])) {
            
            $reponse = htmlspecialchars($_POST['sujet_reponse']);
            
            if(isset($_SESSION['id'])) {
                if(!empty($_POST['sujet_reponse']))  {
                    

                    $ins = $bdd->prepare('INSERT INTO message(id_sujet,id_posteur,date_heure_post,contenu,avatar_posteur,age_createur, grade_createur) VALUES (?,?,NOW(),?, ?, ?,?) ');
                    $ins->execute(array($get_id,$_SESSION['id'],$reponse, $userinfo['avatar'], $userinfo['age'], $userinfo['grade']));
                    
                    $reponse_msg = "Votre message a bien été posté";
                    unset($reponse);
                    header("Location:Sujet.php?titre=$get_titre&id=$get_id");

                } else {
                    $reponse_msg = "votre réponse ne peut pas être vide!"; 
                }
            
            } else {
                $reponse_msg = "Veuillez vous connecter ou créer un compte pour répondre";
            }
        } else {
            $reponse_msg = ""; 
        }
        
        $reponses = $bdd->prepare('SELECT * FROM message WHERE id_sujet = ? ORDER BY date_heure_post');
        $reponses->execute(array($get_id));
        
    } else {
        die('Erreur: titre');
    } 
      
}else {
    die('erreur');
}

if(isset($_POST['message_suppr'])) {
    
}


require('views/Sujet.view.php');
?>