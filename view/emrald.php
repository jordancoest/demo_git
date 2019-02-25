<?php 

$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<p><b>Appel à publication Emerald</b></p>";

$sql = "SELECT titreAppel, resume, dateFinSoumission, datePublication, lien FROM appelAPublication";
$result = $conn->query($sql);

echo "<table border='1px'>";
echo "<tr><th>titreAppel</th><th>resume</th><th>dateFinSoumission</th><th>datePublication</th><th>apercu</th><th>lien</th></tr>";

while($row = $result->fetch(PDO::FETCH_ASSOC)){   //Creates a loop to loop through results
    echo "<tr><td>" . $row['titreAppel'] . "</td><td>" . $row['resume'] ."</td><td>".$row['dateFinSoumission']."</td><td>".$row['datePublication']."</td>
        <td><a href=".$row['lien'].">lien</a></td>
        <td><a href=emrald.php?f=".$row['lien'].">apercu annonce</a></td></tr>";  //$row['index'] the index here is a field nam
}

echo "</table>"; //Close the table in HTML
$conn = null;


$fichier = $_GET['f'];
require_once './simplehtmldom_1_7/simple_html_dom.php';
    
$html = file_get_html($fichier);

$text = ""; 
foreach($html->find('div[id="pgSectionCn"] p') as $e){
    //echo "div ".$e->innertext  . '<br>';
    $text = $text.$e->innertext;
}
$text = strip_tags_content($text);
$text = strip_tags($text);
$text = str_replace("&nbsp;", " ", $text);
$rest = substr($text, 0, 1000);
echo "<script type='text/javascript'>
alert('$rest');
</script>";



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