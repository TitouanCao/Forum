<?php 
    include("menu.php");
    $bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
}
?>


<html>
    <head>
        <link rel="stylesheet" type="text/css" href="CSS/liste_membres.css" media="screen">
    </head>
    <body>
        <br /><br /><br /><br /><br />
        <h1 id="titrel">Liste des membres</h1>
        <div align="center">
            <div id="listemembre">
                
                <table align="center" id="tableliste">
                    <tr height="50px" class="ligne">
                        <td width="200px" class="colonne1">Pseudo:</td>
                        <td width="200px" class="colonne1">Avatar:</td>
                        <td width="200px" class="colonne1">Grade:</td>
                        <td width="200px" class="colonne1">Age:</td>
                        <td width="200px" class="colonne1">Adresse email:</td>
                        <?php if(isset($userinfo) AND $userinfo['grade'] == "chef") { ?> <td width="200px" class="colonne1">Modération</td> <?php } ?> 
                    </tr>
                    
                    <?php $reqli = $bdd->query('SELECT * FROM espacemembre ORDER BY id DESC');
                    while($liste = $reqli->fetch()) { ?>
                    
                    <tr height="80px" class="ligne">
                        <td width="200px" class="colonne"><?php echo $liste['pseudo']; ?> </td>

                        <td width="300px" class="colonne"><?php if(!empty($liste['avatar'])) { ?><img src="Avatar/<?php echo $liste['avatar']; ?>" height="80px"></td> <?php } else { echo "Pas d'avatar"; } ?>
                        
                        <td width="300px" class="colonne"><?php echo $liste['grade'] ?></td>

                        <td width="100px" class="colonne"><?php echo $liste['age']; ?> ans </td>

                        <td width="500px" class="colonne"><?php echo $liste['mail']; ?></td>
                        
                        <?php if(isset($userinfo) AND $userinfo['grade'] == "chef" AND $liste['grade'] != "chef")  {
                        ?> <td width="100px" class="colonne"> <a id="exclusion" href="Supprimer_membre.php?idmembre=<?= $liste['id'] ?>">Exclure</a> <br />
                        
                        <?php if($liste['grade'] == "Modérateur") { ?> 
                        <a id="retro" href="Retrograder.php?idmembre=<?= $liste['id']?>">Rétrograder</a>
                        
                        <?php } else { ?>
                        <a id="promotion" href="Promouvoir.php?idmembre=<?= $liste['id'] ?>">Promouvoir</a></td>
                        <?php } ?>
                    <?php } ?>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </body>
</html>