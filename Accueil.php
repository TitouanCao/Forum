<?php
include('menu.php');
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

$categories = $bdd->query('SELECT * FROM categories ORDER BY id');
$subcat = $bdd->prepare('SELECT * FROM souscategorie WHERE id_categorie = ? ORDER BY id');


if(isset($_GET['notif']) AND $_GET['notif'] == 1) {
   ?> <p> <?php echo "Sujet supprimé avec succès"; ?></p> <?php 
    
}

?>




<html>
    <head>
        <title>Forum Akamonedydy</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="CSS/Accueil.css" media="screen">
                       
    </head>
    <body>
        
        <video autoplay loop poster="Akamonedydy_sourd.mp4" id="video">
          <source src="Akamonedydy_sourd.mp4" type="video/mp4">
        </video>
       
        
    </body>
    
</html>



