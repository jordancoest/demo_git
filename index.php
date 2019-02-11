<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<?php

        $servername = "127.0.0.1";
        $username = "Root";
        $password = "root";
        $dbname = "Projet_call";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // $sql = "SELECT issn,titre,cat,cnrs,fnege,hceres FROM revues";
        // $result = $conn->query($sql);
        // //echo "$result";
        // echo "<br>";
        // echo "<h1> <strong> Listes des Revues </strong> : </h1> ";
        // echo "<br>";


        // if ($result->num_rows > 0) {
        //     echo "<table> <tr> <th>ISSN</th> <th>Titre</th> <th>Cat</th>  <th>cnrs</th>  <th>fnege</th>  <th>hceres</th> </tr>";
        //     // output data of each row
        //     while($row = $result->fetch_assoc()) {
        //         echo "<tr><td>".$row["issn"]."</td><td>".$row["titre"]." </td><td>".$row["cat"]."</td><td>".$row["cnrs"]."</td><td>".$row["fnege"]."</td><td>".$row["hceres"]."</td>             </tr>";
        //     }
        //     echo "</table>";
        // } else {
        //     echo "0 results";
        // }

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
// parcour de l'objet pour extraire les données
foreach ($xml->channel->item as $value) {

	echo "<br>";
	echo "<li> Titre: ".$value->title;"</li>";
	echo "<li> Lien: ".$value->link;"</li>";
	echo "<li> Description: ".$value->description;"</li>";
	echo "<br>";

	// Insertion dans la basse de donnés
	$sql_query_insert ="INSERT INTO appelAPublication ( titreAppel,résumé,lien)
 						VALUES ('$value->title', '$value->description','$value->link')";

	if ($conn->query($sql_query_insert) === TRUE) {
    echo "Insertion OK";
} else {
    echo "Error: " . $sql_query_insert . "<br>" . $conn->error;
}	
}
// fermeture de la session cURL
curl_close($curl);

// fermeture de la connexion a la bd
$conn->close();

?>
</ul> </body>