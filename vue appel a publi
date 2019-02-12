<?php 

$conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<p><b>Appel à publication Emerald</b></p>";

$sql = "SELECT titreAppel, resume, dateFinSoumission, datePublication, lien FROM appelAPublication";
$result = $conn->query($sql);

echo "<table border='1px'>";
echo "<tr><th>titreAppel</th><th>resume</th><th>dateFinSoumission</th><th>datePublication</th><th>lien</th></tr>";
while($row = $result->fetch(PDO::FETCH_ASSOC)){   //Creates a loop to loop through results
echo "<tr><td>" . $row['titreAppel'] . "</td><td>" . $row['resume'] ."</td><td>".$row['dateFinSoumission']."</td><td>".$row['datePublication']."</td><td><a>".$row['lien']."</a></td></tr>";  //$row['index'] the index here is a field name
}

echo "</table>"; //Close the table in HTML

mysql_close();

$conn = null;
?>
