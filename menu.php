<link rel="stylesheet" type="text/css" href="views/menu.css" media="screen">

<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=forum", "root", "");

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
}

$categories = $bdd->query('SELECT * FROM categories ORDER BY id');
$subcat = $bdd->prepare('SELECT * FROM souscategorie WHERE id_categorie = ? ORDER BY id');

        while($c = $categories->fetch()) {
        $subcat->execute(array($c['id']));
        $souscategorie = '';
        while($sc = $subcat->fetch())  {
        $souscategorie .= '<a  id="cat">' .$sc['nom'].'</a>  |  '; }
        $souscategorie = substr($souscategorie, 0, -3); ?>
            <?php  } ?>                     


<nav>
<div id="titre" >
        <a href="Accueil.php" id="titretext">Akamonedydy</a>
        <div align="center">
        <a href="Accueil.php"><img src="views/photo.jpg" alt='logo' id="logo"></a>
        </div>
</div>
<div id="menu">


        <ul id="menubis">

                <li>
                        <a href="#">Black Desert</a>
                                
                            <ul>
                                <li><a href="Structure.php?categorie=Black Desert&souscategorie=Annonces">Annonces</a></li>
                                <li><a href="Structure.php?categorie=Black Desert&souscategorie=Discussions">Discussions</a></li>
                                <li><a href="Structure.php?categorie=Black Desert&souscategorie=JCE">JCE</a></li>
                                <li><a href="Structure.php?categorie=Black Desert&souscategorie=JCJ">JCJ</a></li>
                            </ul>

                </li>
                <li>
                        <a href="#">Tera</a>
                        <ul>
                                <li><a href="Structure.php?categorie=Tera&souscategorie=Annonces">Annonces</a></li>
                                <li><a href="Structure.php?categorie=Tera&souscategorie=Discussions">Discussions</a></li>
                                <li><a href="Structure.php?categorie=Tera&souscategorie=JCE">JCE</a></li>
                                <li><a href="Structure.php?categorie=Tera&souscategorie=JCJ">JCJ</a></li>
                        </ul>
                </li>
                <li>
                        <a href="#">Revelation</a>

                        <ul>
                                <li><a href="Structure.php?categorie=Revelation&souscategorie=Annonces">Annonces</a></li>
                                <li><a href="Structure.php?categorie=Revelation&souscategorie=Discussions">Discussions</a></li>
                                <li><a href="Structure.php?categorie=Revelation&souscategorie=JCE">JCE</a></li>
                                <li><a href="Structure.php?categorie=Revelation&souscategorie=JCJ">JCJ</a></li>         
                        </ul>
                </li>
                <li>
                        <a href="#">Membre</a>
                        <ul>
                                <li><a href="Espace_membre_profil.php">Profil</a></li>
                                <li><a href="Liste_membres.php">Liste des membres</a></li>
                                <li><a href="Espace_membre_deconnexion.php">Deconnexion</a></li>
                        </ul>
                </li>
                <li><?php if(isset($userinfo['avatar']) AND $userinfo['avatar'] != 0) { ?>
                    <img src="Avatar/<?php echo $userinfo['avatar']; ?>" width="100" class="avatarutilisateur" /> <?php
                     }else if(isset($userinfo['pseudo'])) {  ?><h3 id="prof"> Bienvenue <?php echo $userinfo['pseudo']; ?> </h3><?php } else { ?>
                    
                    <a href="Espace_membre_connexion.php">Connexion</a> 
                            <ul>
                                <li><a href="Espace_membre_Inscription.php">Inscription</a></li>
                            </ul>
                    <?php } ?>
                           
                </li>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </ul>  
    </div>
</nav>
<br />








        