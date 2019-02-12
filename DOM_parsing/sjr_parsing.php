<?php
include('simple_html_dom.php');

// détermination de la page source
$html = file_get_html('https://www.scimagojr.com/journalsearch.php?q=11400153311&tip=sid');

// H-INDEX
foreach($html->find('div.hindexnumber') as $e)
    echo 'H-index : '.$e->innertext . '<br>';

// LIEN VERS L'IMAGE RECAP
foreach($html->find('img.imgwidget') as $e)
    echo "Lien vers l'image récap : ".$e->src . '<br>';

// SJR
$sjr = $html->find('div.cellcontent', 1)->find('td');
echo 'SJR : ' . end($sjr);

?>