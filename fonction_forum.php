<?php

function get_pseudo($id)  {
    global $bdd;
    $pseudo = $bdd->prepare('SELECT * FROM espacemembre WHERE id = ?');
    $pseudo->execute(array($id));
    $pseudo = $pseudo->fetch()['pseudo'];
    return $pseudo;
}

function reponse_nbr_topic($id_topic) {
   global $bdd;
   $nbr = $bdd->prepare('SELECT message.id FROM message LEFT JOIN topics ON topics.id = message.id_sujet WHERE topics.id = ?');
   $nbr->execute(array($id_topic));
   return $nbr->rowCount();
}
?>