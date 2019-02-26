<?php 


$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];


$conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<p><b>Appel à publication Emerald</b></p>";

$sql = "SELECT titreAppel, resume, dateFinSoumission, datePublication, lien, idRevue, issn, titreRevue, classementHCERES, sjr, hIndex, widgetRecap FROM appelAPublication natural join revue ";

$result = $conn->query($sql);

echo "<table border='1px'>";
echo "<tr><th>titreAppel</th><th>resume</th><th>dateFinSoumission</th><th>lien appel</th><th>titre revue</th><th>hceres</th><th>sjr</th><th>hIndex</th><th>recap</th></tr>";

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $titreAppel = $row['titreAppel'];
    $lienAppel = $row['lien'];
    $datefin = $row['dateFinSoumission'];
    $resume = $row['resume'];
    $idRevue = $row['idRevue'];

    $titreRevue =  $row['titreRevue'];
    //$lienrevue = $row['urlSiteRevue'];
    $classementHCERES = $row['classementHCERES'];
    $sjr = $row['sjr'];
    $hIndex = $row['hIndex'];
    $widgetRecap = $row['widgetRecap'];
    //$editeur = $row['editeur'];

    //        <td>". $lienrevue ."</td>                    <td>". $editeur ."</td>
    echo "<tr>
        <td>" . $titreAppel . "</td>
        <td>" . $resume ."</td>
        <td>". $datefin ."</td>
        <td><a href=". $lienAppel .">lien</a></td>
        <td>". $titreRevue ."</td>
        <td>". $classementHCERES ."</td>
        <td>". $sjr ."</td>
        <td>". $hIndex ."</td>
        <td><img src=". $widgetRecap ."></td>
        </tr>";  //$row['index'] the index here is a field nam
}

echo "</table>"; //Close the table in HTML

function infoRevue($idrevue){

    $conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql2 = "SELECT issn, titreRevue, classementHCERES, sjr, hIndex, widgetRecap/*, urlSiteRevue, editeur*/ FROM revue where idRevue = '$idrevue'";
    $result2 = $conn->query($sql2);
     
    $row2 = $result2->fetch(PDO::FETCH_ASSOC);

    $titreRevue =  $row2['titreRevue'];
    //$lienrevue = $row2['urlSiteRevue'];
    $classementHCERES = $row2['classementHCERES'];
    $sjr = $row2['sjr'];
    $hIndex = $row2['hIndex'];
    $widgetRecap = $row2['widgetRecap'];
    //$editeur = $row2['editeur'];

    $donnee = array($titreRevue/*$lienrevue*/, $classementHCERES, $sjr, $hIndex, $widgetRecap /*$editeur*/);
    return $donnee;
}


$conn = null;

?>
