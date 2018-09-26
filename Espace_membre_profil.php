<?php
include('menu.php');
    
    
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
    
?>
<html>
    <head>
        <title>Espace Membre</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" type="text/css" href="views/Fond_Espace_membre.css" />
    </head>
    <body>      
        <br /><br /><br /><br /><br />
        <div align="center" id="texte">
            <h2>Profil de <?php echo $userinfo['pseudo']?></h2>
            
            <?php 
            if(!empty($userinfo['avatar']))
            {
                ?>
                    <img  id="avatarutilisateur" src="Avatar/<?php echo $userinfo['avatar']; ?>" height="150" />
                <?php
            }
            else
            {
                echo '<font color = "red">'. "Vous n'avez pas de photo de profil !". "</font>";
                ?> <br /> <?php
            }
               
            ?>
            
            <h4>Votre Pseudo : <?php echo $userinfo['pseudo']?></h4>
            
            <h4>Votre adresse mail : <?php echo $userinfo['mail']?></h4>
            
            <h4>Vous avez : <?php echo $userinfo['age']?> ans</h4>
            
            <?php if(!empty($userinfo['grade'])) { ?><h4> Vous êtes gradé : <?php echo $userinfo["grade"]?></h4> <?php } ?>
        
            
           
        </div>
        <div id="Lienext">
        <?php
            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
            {
            ?>
            <h5><a href="Espace_membre_editerprofil.php">Editer mon profil</a></h5> 
            
            <?php
            }
            ?>
        </div>

<?php 
} else { ?> <br/><br/><br/><br/><br/><br/><br/><br/><br/><div align="center" ><h1><font color = "red"><font family = "Arial">Vous  n'êtes pas connecté</font></font></h1></div> <?php }
?>  

   </body>
</html>