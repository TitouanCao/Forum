<?php 

include('menu.php');
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");


if(isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
}
$topics = $bdd->query('SELECT * FROM topics ORDER BY id DESC');
    
if(isset($_GET['categorie']) AND !empty($_GET['categorie'])) {
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
    if(@id_categorie) {
        if(isset($_GET['souscategorie']) AND !empty($_GET['souscategorie'])) {
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
        }
        $req = " SELECT *, topics.id topic_base_id FROM topics
    LEFT JOIN topic_categorie ON topics.id = topic_categorie.id_topic
    LEFT JOIN categories ON topic_categorie.id_categorie = categories.id
    LEFT JOIN souscategorie ON topic_categorie.id_sous_categorie = souscategorie.id
    LEFT JOIN espacemembre ON topics.id_createur = espacemembre.id
    WHERE categories.id = ? AND souscategorie.id = ? ORDER BY topics.id DESC";

    $topics = $bdd->prepare($req);
    $topics->execute(array($id_categorie, $id_souscategorie));
       
        
        
    } else {
       die('Erreur: catégorie introuvable'); 
    }

    
} else {
    die();
}

require('fonction_forum.php');
require('views/structure.view.php');

    
    ?>

