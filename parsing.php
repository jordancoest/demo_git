<?php
include("../bdd/pdo.php");
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
$conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// parcour de l'objet pour extraire les données
foreach ($xml->channel->item as $value) {

    //attribution des variables et enleve les apo
    $title = str_replace("'", " ", $value->title);
    $link = str_replace("'", " ", $value->link);
    $description = str_replace("'", " ", $value->description);
    $datePu = date("d/M/20y");
    //récupere la date de fin depuis la description avec les expression réguliere 
    preg_match("`([0-9]*[a-z]* [a-zA-Z]* [0-9]{4})`", $value->description, $res_regex);
    $datefin = $res_regex[1];
    //récupere le nom de la revu pour pouvoire récuperer lid 
    preg_match("`(from (.*), final)`", $value->description, $res_regex2);
    $revue = $res_regex2[2];

    //affichage de test
	echo "<br>";
	echo "<li> Titre: ".$value->title;"</li>";
	echo "<li> Lien: ".$value->link;"</li>";
	echo "<li> Description: ".$value->description;"</li>";
	echo "<br>";   
    echo "Deadline : ".$datefin;
    echo "<br>Revue : ".$revue;
    echo "<br> date publication :".$datePu."<br>";

    //requete sql pour savoir si lappell exist deja dans la bdd
    $existsql = "SELECT EXISTS( SELECT * FROM appelAPublication WHERE titreAppel = '$title' AND resume = '$description' AND lien = '$link' AND dateFinSoumission = '$datefin')";
    $stmt = $conn->query($existsql);
    $count = $stmt->fetch();

    // if pour savoir si la requete retourne qlq chose
    if ($count[0] > 0) {
        //si elle existe deja on fait rien
    }else{
        //sinon on insert lappel dans la base
        $sql = "INSERT INTO appelAPublication ( titreAppel,resume,lien,dateFinSoumission,datePublication)VALUES ('$title', '$description','$link', '$res_regex[1]', '$datePu')";
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

?>
