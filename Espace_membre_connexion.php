<?php
include('menu.php');

    
    
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_POST['formconnexion']))
{
    $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($pseudoconnect) AND !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM espacemembre WHERE mdp = ? AND pseudo = ?");
        $requser->execute(array($mdpconnect, $pseudoconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['age'] = $userinfo['age'];
            $_SESSION['avatar'] = $userinfo['avatar'];
            $_SESSION['grade'] = $userinfo['grade'];
            header("Location: Espace_membre_profil.php?id=".$_SESSION['id']);
            
        }
        else
        {
            $erreur = "Pseudo ou mot de passe incorrect";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être remplis !";
    }
}


?>
<html>
    <head>
        <title>Connexion</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" type="text/css" href="views/Fond_Espace_membre.css" />
    </head>
    <body>
        

        
        <br /><br /><br /><br />
        <div align="center" id="texte">
            
            <h1>Connexion</h1>
            
            <br />
            
            <form method="POST" action="">
                
                    <input type="text" name="pseudoconnect" placeholder="Pseudo"  >
                    <input type="password" name="mdpconnect" placeholder="Mot de passe"><br /><br/>
                    <input type="submit" name="formconnexion" value="Se connecter !" >
            
            </form>
            
            <h3>
                <?php
            if(isset($erreur))
            {
                echo '<font color = "red">'. $erreur  ."</font>";
            }
            ?>
                
            </h3>
            </div>
        <div align="center">
            <ul id="Lienext" align="center">
                <h3>
                    <li><a href="Espace_membre_Inscription.php">S'inscrire</a>

                    <a href="Accueil.php">Accueil</a></li>
                </h3>
            </ul>
        </div>
    </body>
</html>


