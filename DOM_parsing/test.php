
<?php

    require_once './simplehtmldom_1_7/simple_html_dom.php';

	$html = file_get_html('http://www.emeraldgrouppublishing.com/authors/writing/calls.htm?id=7874');

	$text = "";
	foreach($html->find('div[id="pgSectionCn"] p') as $e){
	    //echo "div ".$e->innertext  . '<br>';
	    $text = $text.$e->innertext;
	}



	$debut = $html->find('div[id="pgSectionCn"] p', 1);

	echo $debut;
	//$debut = strip_tags($debut);
	//$text = strip_tags($text);

	//$rest = preg_replace($debut, $text);

	//**/$rest = substr($text, 0, 1000);
/*
	echo $debut;
	echo "<br><br><br>";
	echo $text;*/
?>
