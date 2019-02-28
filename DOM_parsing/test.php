
<?php

    require_once ('simple_html_dom.php');

	$html = file_get_html('http://www.emeraldgrouppublishing.com/authors/writing/calls.htm?id=7874');

	$text = "";
	foreach($html->find('div[id="pgSectionCn"] p') as $e){
	    //echo "div ".$e->innertext  . '<br>';
	    $text = $text.$e->innertext;
	    echo "salut";
	    echo "salut";
	}
	
?>
