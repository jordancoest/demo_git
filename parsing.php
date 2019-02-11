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
$conn = new PDO("mysql:host=localhost;dbname=Projet_call", "root", "Ayman789520");

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// parcour de l'objet pour extraire les données
foreach ($xml->channel->item as $value) {


    $title = $value->title;
    $title = str_replace("'", " ", $title);
    $link = $value->link;
    $link = str_replace("'", " ", $link);
    $description = $value->description;
    $description = str_replace("'", " ", $description);

	echo "<br>";
	echo "<li> Titre: ".$value->title;"</li>";
	echo "<li> Lien: ".$value->link;"</li>";
	echo "<li> Description: ".$value->description;"</li>";
	echo "<br>";
    preg_match("`([0-9]*[a-z]* [a-zA-Z]* [0-9]{4})`", $value->description, $res_regex);
    echo "Deadline : ".$res_regex[1];
        $datefin = $res_regex[1];
    preg_match("`(from (.*), final)`", $value->description, $res_regex2);
    echo "<br>Revue : ".$res_regex2[2];
    echo "<br>";

        $sql = "INSERT INTO appelAPublication ( titreAppel,resume,lien)VALUES ('$title', '$description','$link')";
        $conn->exec($sql);
}

}catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

curl_close($curl);
$conn = null;



   

?>
