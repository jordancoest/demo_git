<?php

set_time_limit(2000);

include('simple_html_dom.php'); // Manuel : http://simplehtmldom.sourceforge.net/manual.htm

//connexion à la base de données
$db = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//parsing_revue(25501, $db);

$requeteListeDesID = "SELECT idSJR FROM revue";
$stmt = $db->query($requeteListeDesID);
$listeDesID = $stmt->fetchall();

foreach ($listeDesID as $idSJR) {
    if ($idSJR[0] != NULL) parsing_revue($idSJR[0], $db);
}

function parsing_revue($idRevueSJR, $bdd){

    // détermination de la page source
    $html = file_get_html('https://www.scimagojr.com/journalsearch.php?q='.$idRevueSJR.'&tip=sid');

    // Titre de la revue
    $titre = $html->find('title', 0)->innertext;
    $titre=str_replace("'","\'",$titre);
    $titre=str_replace("–","-",$titre);
    $titre=str_replace("Ä","A",$titre);
    $titre=utf8_encode($titre);
    //echo 'Titre : ' . $titre . '<br>';

    // H-INDEX
    $hindex = $html->find('div.hindexnumber', 0)->innertext;
    //echo 'H-INDEX : ' . $hindex . '<br>';

    // LIEN VERS L'IMAGE RECAP
    $widget = $html->find('img.imgwidget', 0)->src;
    //echo 'Lien vers l\'image récap : ' . $widget . '<br>';

    // SJR
    $listeSJR = $html->find('div.cellcontent', 1)->find('td');
    $sjr = end($listeSJR)->innertext;
    //echo 'SJR : ' . $sjr . '<br>';

    // EDITEUR
    $editeur = $html->find('a[title="view all publisher\'s journals"]', 0)->innertext;
    $editeur=str_replace("'","\'",$editeur);
    if ($editeur == "") $editeur = "NC";
    //echo 'Nom de l\'éditeur : ' . $editeur . '<br>';

    // LIEN VERS LA REVUE
    if (isset($html->find('a[id="question_journal"]', 0)->href)){
        $lien = $html->find('a[id="question_journal"]', 0)->href;
        //echo 'Lien vers la revue : ' . $lien . '<br><br>';
    }
    else{
        $lien = "NC";
        //echo $lien.'<br><br>';
    }

    $sql = "UPDATE revue SET titreRevue='$titre', hIndex=$hindex, widgetRecap='$widget', sjr=$sjr, editeur='$editeur', urlSiteRevue='$lien' WHERE idSJR=$idRevueSJR";
    $bdd->exec($sql);

}

echo "fini pour toutes les revues !";

?>