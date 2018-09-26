

<?php

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


if(isset($_GET['categorie'])) {
    $get_categorie = htmlspecialchars($_GET['categorie']);
    $categories = array();
    $req_categories = $bdd->query('SELECT * FROM categories');
    while($c = $req_categories->fetch()) {
        array_push($categories, array($c['id'],$c['nom']));
    }
    foreach($categories as $cat) {
        if(in_array($get_categorie, $cat)) {
            $id_categorie = intval($cat[0]);
        }
    }

    $get_categorie = htmlspecialchars($id_categorie);
    $categorie = $bdd->prepare('SELECT * FROM categories WHERE id = ?');
    $categorie->execute(array($get_categorie));
    $cat_exist = $categorie->rowCount();
    

    
    if($cat_exist == 1) {
            $get_souscategorie = htmlspecialchars($_GET['souscategorie']);
            $souscategories = array();
            $req_souscategories = $bdd->prepare('SELECT * FROM souscategorie WHERE id_categorie = ?');
            $req_souscategories->execute(array($id_categorie));
            while($c = $req_souscategories->fetch()) {
                array_push($souscategories, array($c['id'], $c['nom']));
            }
            foreach($souscategories as $cat)  {
                if(in_array($get_souscategorie, $cat)) {
                    $id_souscategorie = intval($cat[0]);
                }
            }
        $get_souscategorie = htmlspecialchars($id_souscategorie);
        $categorie = $categorie->fetch();
        $categorie = $categorie['nom'];
        
        $souscategorie = $bdd->prepare('SELECT * FROM souscategorie WHERE id_categorie = ? AND id = ?');
        $souscategorie->execute(array($get_categorie, $get_souscategorie));
        $sc_exist = $souscategorie->rowCount();
        

        
        if($sc_exist == 1) {
            $souscategorie = $souscategorie->fetch();
            $souscategorie = $souscategorie['nom'];
        
        
            if(isset($_SESSION['id'])) {
                if(isset($_POST['tsubmit'])) {
                    if(isset($_POST['tsujet'], $_POST['tcontenu'])){ 
                        $sujet = htmlspecialchars($_POST['tsujet']);
                        $contenu = htmlspecialchars($_POST['tcontenu']);
                        
                        if(!empty($sujet) AND !empty($contenu)) {
                            if(strlen($sujet) <= 70) {
                                if(isset($_POST['tmail'])) {
                                    $notif_mail = 1;
                                } else {
                                    $notif_mail = 0;
                                }

                                $insert = $bdd->prepare("INSERT INTO topics(id_createur, sujet, contenu, date, notifcrea, resolu, avatar_createur, age_createur, grade_createur) VALUES(?,?,?, NOW(), ?, 0, ?, ?,?)");
                                $insert->execute(array( $_SESSION['id'], $sujet, $contenu, $notif_mail, $userinfo['avatar'], $userinfo['age'], $userinfo['grade']));
                                
                                $lt = $bdd->query('SELECT id FROM topics ORDER BY id DESC LIMIT 0, 1');
                                $lt = $lt->fetch();
                                $id_topic = $lt['id'];
                                
                                $ins = $bdd->prepare('INSERT INTO topic_categorie (id_topic, id_categorie, id_sous_categorie) VALUES (?,?,?) ');
                                $ins->execute(array($id_topic, $get_categorie, $get_souscategorie));

                                $req_cat_nom = $bdd->prepare('SELECT * FROM categories WHERE id = ?');
                                $req_cat_nom->execute(array($get_categorie));
                                $cat_nom = $req_cat_nom->fetch();
                                $cat_nom = $cat_nom['nom'];
                                
                                
                                $req_sscat_nom = $bdd->prepare('SELECT * FROM souscategorie WHERE id = ?');
                                $req_sscat_nom->execute(array($get_souscategorie));
                                $sscat_nom = $req_sscat_nom->fetch();
                                $sscat_nom = $sscat_nom['nom'];
                                
                                $terror = "Message envoye avec succes";
                                
                                header("Location:Structure.php?categorie=$cat_nom&souscategorie=$sscat_nom");
                                
                            } else {
                                $terror = "Votre sujet ne peut pas dépasser 70 caracteres";
                            }
                        } else {
                            $terror = "Veuillez compléter tous les champs";
                        }
                    }
                }

            } else {
                $terror = "Veuillez cous connecter pour poster un nouveau topic";
            }
        } else {
            die('Sous-catégorie invalide');
        }
    } else {
        die('Catégorie invalide');
    }

} else {
    $terror = "Il y a eu un problème";
}
require('views/nouveau_topic.view.php');

?>




  
<html>
    <head>
        <title>Forum Akamonedydy</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="CSS/Accueil.css" media="screen">
                       
    </head>
    <body>
        
        
    </body>
    
</html>

























