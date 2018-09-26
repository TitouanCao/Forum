<?php 
include('menu.php');
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

$grade = "membre";

if(isset($_POST['formu']))
{
    
       $pseudo = htmlspecialchars($_POST['pseudo']);
       $mail = htmlspecialchars($_POST['mail']);
       $mail2 = htmlspecialchars($_POST['mail2']);
       $mdp = sha1($_POST['mdp']);
       $mdp2 = sha1($_POST['mdp2']);
       $age = htmlspecialchars($_POST['age']);
    
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
   {      
       $pseudolenght = strlen($pseudo);
       if($pseudolenght <= 255)
       {
           $reqpseudo = $bdd->prepare("SELECT * FROM espacemembre WHERE pseudo = ?");
           $reqpseudo->execute(array($pseudo));
           $pseudoexist = $reqpseudo->rowCount();
           if($pseudoexist ==0)
           {
               if($mail == $mail2)
               {
                   if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                   { 
                       $reqmail = $bdd->prepare("SELECT * FROM espacemembre WHERE mail = ?");
                       $reqmail->execute(array($mail));
                       $mailexist = $reqmail->rowCount();
                       if($mailexist == 0)
                       {

                           if($mdp == $mdp2)
                               
                                {
                                if($age <= 120 AND $age >= 0 )
                                {
                                    if($age >= 10)
                                    {
                                        $insertmbr = $bdd->prepare("INSERT INTO espacemembre(pseudo, mail, mdp, age, avatar, grade) VALUES(?,?,?,?,0,?)");
                                        $insertmbr->execute(array($pseudo, $mail, $mdp, $age, $grade));
                                        $erreur = "Votre compte a bien été créé";
                                        ?>
                                        <?php
                                        

                                    }
                                    else
                                    {
                                        $erreur = "Vous êtes trop jeune !";
                                    }
                                }
                                else
                                {
                                    $erreur = "Votre âge n'est pas correct !";
                                }
                            }
                           else
                           {
                               $erreur = "Vos mot de passes de correspondent pas !";
                           }
                       }
                       else
                       {
                           $erreur = "Adresse mail déjà utilisée";
                       }
                   }
                   else
                   {
                       $erreur = "Votre adresse mail n'est pas valide";
                   }
               }
               else
               {
                   $erreur = "Vos adresses mail ne correspondent pas !";
               }
           }
           else
           {
               $erreur = "Pseudo déjà utilisé !";
           }
       }
       else
       {
           $erreur = "Votre pseudo ne doit pas dépasser 255 caractéres !";
       }
   }
    else
    {
       $erreur = "Tous les champs doivent être complétés !";
    }
}
    
?>
<html>
    <head>
        <title>Inscription</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" type="text/css" href="views/Fond_Espace_membre.css" />
    </head>
    <body>
        
   
        
        
        
        
        
        
        <br /><br /><br /><br />
        <div align="center" id="texte">
            <h1>Inscription</h1>
            
            <form method="POST" action="">
                <table align="center" id="texte">
                    <tr>
                        <td align="right">
                            <label for="pseudo">Pseudo :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" />
                        </td>
                        <td> <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        <td/>
                    <tr/>
                    <tr>
                        <td align="right">
                            <label for="mail">Adresse email :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre adresse email" id="mail" name="mail" value="<?php if(isset($mail)){ echo $mail; } ?> " />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mail2"> Confirmation de votre adresse email :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre adresse email" id="mail2" name="mail2"value="<?php if(isset($mail2)){ echo $mail2; } ?> " />
                        </td>
                    <tr/>
                    <tr>
                        <td align="right">
                            <label for="mdp">Mot de passe :</label>
                        </td><td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                        </td>
                    <tr/>
                    <tr>
                        <td align="right">
                            <label for="mdp2">Confirmation du mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp2" name="mdp2" />
                        </td>
                    <tr/>
                    <tr>
                        <td align="right">
                            <label for="age">Age :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre âge" id="age" name="age" value="<?php if(isset($age)){echo $age;} ?>"/>
                        </td>
                    <tr/>
                </table>
                <br />
                <input type="submit" name="formu" value="Valider" size="70" style="height:40px;">
                <br /><br />
                
            </form>
            <?php
            if(isset($erreur))
            {
                echo '<h3><font color = "red">'. $erreur ."</font><h3>";
            }
            ?>
        </div>
        <div id="Lienext">
            <a href="Espace_membre_connexion.php">Se connecter !</a>
        </div>
       
    </body>
</html>