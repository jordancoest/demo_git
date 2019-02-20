<?php
include('simple_html_dom.php'); // Manuel : http://simplehtmldom.sourceforge.net/manual.htm

$idSJR = 20191 ; // A FAIRE PASSER EN PARAMETRE DE LA FONCTION DE PARSING

// détermination de la page source
$html = file_get_html('https://www.scimagojr.com/journalsearch.php?q='.$idSJR.'&tip=sid');

// Titre de la revue
$titre = $html->find('title', 0);
echo 'Titre : ' . $titre->innertext . '<br>';

// H-INDEX

$hindex = $html->find('div.hindexnumber', 0)->innertext;
echo 'H-INDEX : ' . $hindex . '<br>';

// LIEN VERS L'IMAGE RECAP

$widget = $html->find('img.imgwidget', 0)->src;
echo 'Lien vers l\'image récap : ' . $widget . '<br>';

// SJR
$sjr = $html->find('div.cellcontent', 1)->find('td');
echo 'SJR : ' . end($sjr) . '<br>';

// EDITEUR

$editeur = $html->find('a[title="view all publisher\'s journals"]', 0)->innertext;
echo 'Lien vers l\'éditeur : ' . $editeur . '<br>';

// LIEN EDITEUR

$lien = $html->find('a[id="question_journal"]', 0)->href;
echo 'Lien vers l\'éditeur : ' . $lien . '<br>';


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
?>