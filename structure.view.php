<html>
    <head>
        <link rel="stylesheet" type="text/css" href="views/categorie.css" media="screen">
    </head>
    <body>
        <br /><br /><br /><br />
        
        <div id="contenu">
            <div>
            
            <h4 id="recap"><?= $_GET['categorie'] ?> | <?= $_GET['souscategorie'] ?> </h4>
            
        </div>
            <div class="pull-left full-width" align="center">
                <table class="forum">
                    <tr id="header">
                        <th class="su">Sujet  |   <a href="/Index/Forum/nouveau_topic.php?categorie=<?= $_GET['categorie'] ?>&souscategorie=<?= $_GET['souscategorie'] ?>" id="nt">Créer un nouveau topic</a> </th>
                        <th class="sub-info">Réponses</th>
                        <th class="sub-info">Dernier Message</th>
                        <th class="sub-info">Creation</th>
                    </tr>
                    
                    <?php while($t = $topics->fetch()) { ?>
                    
                    <tr class="messa">
                        <td align="left" class="sub-info">    
                            <a href="/Index/Forum/Sujet.php?titre=<?= $t['sujet'] ?>&id=<?= $t['topic_base_id'] ?>" id ="ts"><?= $t['sujet'] ?></a> | par: <?= $t['pseudo'] ?><br /> <img src="Avatar/<?php echo $t['avatar_createur']; ?>" width="80" />
                        </td>
                        <td align="center" class="sub-info"><?= reponse_nbr_topic($t['topic_base_id']) ?></td>
                        <td align="center" class="sub-info"></td>
                        <td align="center" class="sub-info">Date :<?= $t ['date'] ?></td>
                    </tr>
                   <?php  } ?>
                </table>
            </div>
        </div>
    </body>
</html>