<?php
include("../bdd/pdo.php");
include("compre_text.php");

set_time_limit(200000);
// création d'une nouvelle ressource cURL
$curl = curl_init();

// configuration de l'URL et d'autres options
curl_setopt($curl, CURLOPT_URL,"http://www.emeraldgrouppublishing.com/authors/writing/calls.xml");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


// récupération de l'URL et affichage sur le naviguateur
$contenu = curl_exec($curl);

// instanciation d'un élément du document XML. 
$xml = new simpleXMLElement($contenu);
?>
<h1>Listes les Calls </h1>
<ul>
<?php

try{
//co a la base
$conn = connexpdo("projet2jpbanj_bdd");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// parcour de l'objet pour extraire les données
foreach ($xml->channel->item as $value) {

    //attribution des variables et enleve les apo
    $title = str_replace("'", " ", $value->title);
    $link = str_replace("'", " ", $value->link);
    $description = resume($value->link);
    $datePu = date("Y-m-d");
    //récupere la date de fin depuis la description avec les expression réguliere 
    preg_match("`([0-9]*[a-z]* [a-zA-Z]* [0-9]{4})`", $value->description, $res_regex);
    $datefin = $res_regex[1];
    $datefin = strtotime($datefin);
    $datefin = date('Y-m-d',$datefin);
    //récupere le nom de la revu pour pouvoire récuperer lid 
    preg_match("`(from (.*), final)`", $value->description, $res_regex2);
    $revue = $res_regex2[2];
    //on récupere l'identifiant depuis le nom de la revu, on fait appel à une fonction externe
    $idRevue = chaine_perc($revue);
    if($idRevue != null){
        $idRevue = max($idRevue);
        $idRevue = $idRevue['idRevue'];
    }else{
        $idRevue = 2848;
    }



    //affichage de test
	echo "<br>";
	echo "<li> Titre: ".$value->title;"</li>";
	echo "<li> Lien: ".$value->link;"</li>";
	echo "<li> Description: ".$description;"</li>";
	echo "<br>";   
    echo "Deadline : ".$datefin;
    echo "<br>id revue : ".$idRevue;
    echo "<br>Revue : ".$revue;
    echo "<br> date publication : ".$datePu."<br>";

    //requete sql pour savoir si lappell exist deja dans la bdd
    $existsql = "SELECT EXISTS( SELECT * FROM appelAPublication WHERE titreAppel = '$title' AND resume = '$description' AND lien = '$link' AND dateFinSoumission = '$datefin')";
    $stmt = $conn->query($existsql);
    $count = $stmt->fetch();

    // if pour savoir si la requete retourne qlq chose
    if ($count[0] == 0){
        //sinon on insert lappel dans la base
        $sql = "INSERT INTO appelAPublication ( titreAppel,resume,lien,dateFinSoumission,datePublication, idRevue, titreRevueTrouve)VALUES ('$title', '$description','$link', '$datefin', '$datePu', '$idRevue', '$revue')";
        $conn->exec($sql);
    }
}
}catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
//ferme le parsing
curl_close($curl);

//fermme la co
$conn = null;

function resume($lien){
    require_once './simplehtmldom_1_7/simple_html_dom.php';
        
    $html = file_get_html($lien);

    $text = ""; 
    foreach($html->find('div[id="pgSectionCn"] p') as $e){
        //echo "div ".$e->innertext  . '<br>';
        $text = $text.$e->innertext;
    }
    $tab = array("<span>","<p>");
    $text = strip_tags_content($text, "<span>");
    $text = strip_tags($text);
    $text = str_replace("&nbsp;", " ", $text);
    $text = str_replace("'", "", $text);
    $rest = substr($text, 0, 1000);

    return $rest;
/*    echo "<script type='text/javascript'>
    alert('$rest');
    </script>";*/
}


function strip_tags_content($text, $tags = '', $invert = FALSE) {

  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);
   
  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
} 
?>
