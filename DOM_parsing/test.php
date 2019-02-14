<?php

    require_once './simplehtmldom_1_7/simple_html_dom.php';

	$html = file_get_html('http://www.emeraldgrouppublishing.com/authors/writing/calls.htm?id=8131');

	$text = "";
	foreach($html->find('div[id="pgSectionCn"] p') as $e){
	    //echo "div ".$e->innertext  . '<br>';
	    $text = $text.$e->innertext;
	}
	preg_match("`(Special issue (.*))`", $text, $res_regex);
	echo $res_regex[2];
?>
