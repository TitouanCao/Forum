
<head>
    <link rel="stylesheet" type="text/css" href="views/Sujet.css" media="screen">
    <script src="js/wysibb.local"></script>
    <script src="js/wysibb.local2"></script>
    <link rel="stylesheet" href="CSS/wbbtheme.css" />
    <script src="js/jquery.wysibb.min.js"></script>
    <script>
        $(function() {
            var optionWbb = {
                buttons: "bold,|,italic,|,underline,|,img,|,link,|,video"
            }
    $("#wysibb").wysibb(optionWbb);
        })
    </script>
    
    
    
</head>
<body>
    <br /><br /><br />
    <div class="Structure">
        <br />
        <div id="main-content">
            <br />
            <h1>Sujet : <?= $topic['sujet'] ?> - par : <?= get_pseudo($topic['id_createur']) ?></h1>
            <div align="center">
                <div class="globalite">
                    <tr align="center">
                        <br />
                        <table class="forum"  height="300px" text-align="top">
                            <tr class="lignemessage">
                                <th rowspan="2" class="titav"><?= get_pseudo($topic['id_createur']) ?><br /><img src="Avatar/<?php echo $topic['avatar_createur']; ?>" width="140" class="avatarutilisateur" /><?php echo $topic['age_createur'] ?> ans <br /><h4 class="grade"><?php echo $topic['grade_createur']; ?></h4> </th>
                                <td class="date">-- Le : <?= $topic['date'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if(isset($_SESSION['id'])) { ?>
                                    <?php if($topic['id_createur'] == $_SESSION['id'] OR $userinfo['grade'] == "chef" OR $userinfo['grade'] == "administrateur") { ?>
                                    <a href="Supprimer_sujet.php?id=<?= $topic['id'] ?>" class="suppr">Supprimer</a> <?php }
                                    ?> <?php } ?>
                                </td>
                            </tr>
                            <tr>

                                <td class="cont" align="top"><p><?php 
                                    $parser->parse($topic['contenu']);
                                    echo $parser->getAsHtml();
                                    ?> </p>
                                </td>

                            </tr>
                        </table>
                        </tr>
                        <?php while($r = $reponses->fetch()) { ?>
                        <tr>
                        <table class="forum" height="300px">
                            <br />
                            <tr class="lignemessage">
                                <th rowspan="2" class="titav"><?= get_pseudo($r['id_posteur']) ?><br /><img src="Avatar/<?php echo $r['avatar_posteur']; ?>" width="140" class="avatarutilisateur"/><?php echo $r['age_createur'] ?>ans <h4 class="grade"> <?php echo $r['grade_createur']; ?> </h4></th>
                                <td class="date">-- Le : <?= $r['date_heure_post'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($_SESSION['id'])) { ?>
                                    
                                    <?php if($r['id_posteur'] == $_SESSION['id'] OR $userinfo['grade'] == "chef" OR $userinfo['grade'] == "administrateur") { ?>
                                    <a href="Supprimer_message.php?id=<?= $r['id'] ?>" class="suppr" >Supprimer</a> <?php  } ?> <?php } ?>

                                </td>
                            </tr>
                            <tr>

                                <td class="cont"><p><?php 
                                    $parser->parse($r['contenu']);
                                    echo $parser->getAsHtml();
                                    ?> </p>
                                </td>
                            </tr>

                            <?php } ?>
                        </table>
                        </tr>
                    <br />
                     <?php if(isset($_SESSION['id'])) { ?>
                        <form method="POST" id="rep">
                            <div id="editeur">
                            <textarea placeholder="Votre réponse" id="wysibb" name="sujet_reponse" style="width:60%"><?php if(isset($reponse)) {echo $reponse; } ?></textarea><br />
                            <input type="submit" name="sujet_reponse_submit" value="Poster ma réponse">
                            </div>
                        </form> 
                        <br />
                        <?php if(isset($reponse_msg)) {echo $reponse_msg;}   
                    } else { ?> <p>Veuillez vous connecter pour répondre </p> <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>