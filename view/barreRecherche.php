<?php
include('form.php');
echo "<pre>";
$code  = form("emrald.php", "get", "Recherche ");
$code .= text("Recherch : ", "ftext");
echo "</br></br>";
$code .= radio("titreAppel : ", "op", "titreAppel");
$code .= radio("titreRevue: " , "op", "titreRevue");
$code .= submit("Afficher", "Reset");   
$code .= finform();
echo $code."</pre>";

?>