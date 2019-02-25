<?php
include('simple_html_dom.php'); // Manuel : http://simplehtmldom.sourceforge.net/manual.htm

//co a la base
$db = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requeteListeDesID = "SELECT idSJR FROM revue limit 1000";
$stmt = $db->query($requeteListeDesID);
$listeDesID = $stmt->fetchall();
//var_dump($listeDesID);
foreach ($listeDesID as $idSJR) {

    //var_dump ($idSJR);
    if ($idSJR[0] != NULL) parsing_revue($idSJR[0], $db);

}

function parsing_revue($idRevueSJR, $bdd){

    // détermination de la page source
    $html = file_get_html('https://www.scimagojr.com/journalsearch.php?q='.$idRevueSJR.'&tip=sid');

    // Titre de la revue
    $titre = $html->find('title', 0)->innertext;
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
    //echo 'Nom de l\'éditeur : ' . $editeur . '<br>';

    // LIEN EDITEUR

    if (isset($html->find('a[id="question_journal"]', 0)->href)){
        $lien = $html->find('a[id="question_journal"]', 0)->href;
        //echo 'Lien vers l\'éditeur : ' . $lien . '<br><br>';
    }
    else{
        $lien = 'Pas de lien dispo pour l\'éditeur';
        //echo $lien.'<br><br>';
    }

    $sql = "UPDATE revue SET titreRevue='$titre', hIndex=$hindex, widgetRecap='$widget', sjr=$sjr WHERE idSJR=$idRevueSJR";
    $bdd->exec($sql);


    /*
    ** VERSION AVEC FOREACH

    // H-INDEX
    foreach($html->find('div.hindexnumber') as $e)
    echo 'H-index : '.$e->innertext . '<br>';

    // LIEN VERS L'IMAGE RECAP
    foreach($html->find('img.imgwidget') as $e)
    echo "Lien vers l'image récap : ".$e->src . '<br>';

    // EDITEUR
    foreach($html->find('a[title="view all publisher\'s journals"]') as $e)
    echo "Nom de l'éditeur : ".$e->innertext . '<br>';

    // LIEN VERS L'EDITEUR
    foreach($html->find('a[id="question_journal"]') as $e)
    echo "Lien vers l'éditeur : ".$e->href . '<br>';

    */

}

echo "fini !";

?>