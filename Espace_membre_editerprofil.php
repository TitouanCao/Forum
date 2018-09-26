<?php
include('menu.php');
    
    
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_SESSION['id']))
{  
    $requser=$bdd->prepare("SELECT * FROM espacemembre WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    
    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE espacemembre SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header("Location:Espace_membre_profil.php?id=".$_SESSION['id']);
    }

    
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE espacemembre SET mail = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header("Location:Espace_membre_profil.php?id=".$_SESSION['id']);
    }  
    if(isset($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp1']) AND !empty($_POST['newmdp2']) AND $_POST['newmdp1'] != $user['mdp'])
    {
        if($_POST['newmdp1'] == $_POST['newmdp2'])
        {
            $newmdp = sha1($_POST['newmdp1']);
            $insertmdp = $bdd->prepare("UPDATE espacemembre SET mdp = ? WHERE id = ?");
            $insertmdp->execute(array($newmdp, $_SESSION['id']));
            header("Location:Espace_membre_profil.php?id=".$_SESSION['id']);
        }
        else
        {
            $erreur2 = "Les deux mot de passes ne sont pas identiques !";
        }
    }
    
    if(isset($_POST['newage']) AND !empty($_POST['newage']) AND $_POST['newage'] != $user['age'])
    {
        $newage = htmlspecialchars($_POST['newage']);
        $insertage = $bdd->prepare("UPDATE espacemembre SET age = ? WHERE id = ?");
        $insertage->execute(array($newage, $_SESSION['id']));
        header("Location:Espace_membre_profil.php?id=".$_SESSION['id']);
    }
    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
    {
        $taillemax = 2097152;
        $extensionsValides = array('jpg');
        if($_FILES['avatar']['size'] <= $taillemax)
        {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides))
            {
                $chemin = "Avatar/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if($resultat)
                {
                    $updateavatar = $bdd->prepare("UPDATE espacemembre SET avatar = :avatar WHERE id = :id");
                    $updateavatar->execute(array('avatar' => $_SESSION['id'].".".$extensionUpload,
                                                'id' => $_SESSION['id']));
                    header("Location:Espace_membre_profil.php?id=".$_SESSION['id']);
                }
                else
                {
                    $erreur2 = "Erreur dans l'importation de votre photo";
                }
            }
            else
            {
            $erreur2 = "Format de la photo non accepté";
            }
        }
        else
        {
            $erreur2 = "Le fichier ne peut pas dépasser 2Mo";
        }
    }

?>
<html>
    <head>
        <title>Espace Membre</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" type="text/css" href="views/Fond_Espace_membre.css" />
    </head>
    <body>
  
        
        <br /><br /><br /><br />
        
        <div align="center" id="texte">
            <h1>Edition du profil</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <table align="center" id="texte">
                    <tr>
                        <td>
                            <label>Pseudo :</label>
                        </td>
                        <td>
                            <input type="text" name="newpseudo" placeholder="Votre nouveau pseudo" value="<?php echo $user['pseudo'] ?>"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mail :</label>
                        </td>
                        <td>
                            <input type="text" name="newmail" placeholder="Votre nouvelle adresse mail" value="<?php echo $user['mail'] ?>"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" name="newmdp1" placeholder="Votre nouveau mot de passe" value="<?php echo $user['mdp'] ?>"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" name="newmdp2" placeholder="Confirmez votre nouveau mot de passe" value="<?php echo $user['mdp'] ?>"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Age :</label>
                        </td>
                        <td>
                            <input type="text" name="newage" placeholder="Votre nouvel age" value="<?php echo $user['age'] ?>"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label> Avatar :</label>
                        </td>
                        <td>
                            <input type="file" name="avatar"/>
                        </td>
                    </tr>
                </table>
                <input type="submit" value ="Mettre a jour mon profil"/> <br /><br />
            
            </form>
            
            <?php
                if(isset($erreur2))
                {
                    echo '<h3><font color="red">'. $erreur2 .'</font></h3>';
                }
            ?>
        </div>
        <div id="Lienext">
            <h3><a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">Retour</a></h3>
        </div>
    </body>
</html>
<?php
}

?>