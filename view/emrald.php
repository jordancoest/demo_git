<?php 
include ("../CURL_XML_parsing/enleverCaracteresSpeciaux.php");
include ("barreRecherche.php");

$conn = new PDO("mysql:host=mysql-projet2jpbanj.alwaysdata.net;dbname=projet2jpbanj_bdd", "176186", "projetBANJ");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT titreAppel, resume, dateFinSoumission, datePublication, lien, idRevue, issn, titreRevue, classementHCERES, sjr, hIndex, widgetRecap FROM appelAPublication natural join revue ";
$result = $conn->query($sql);

function afficheTab($tab){
  $url = $_SERVER['PHP_SELF'];
  echo "<p><b>Appel à publication Emerald</b></p>";
  echo "<table border='1px'>";
    echo "<tr><th>titreAppel</th><th>resume</th><th><a href=\"$url/emrald.php?dateFinSoumission=dateFinSoumission\">dateFinSoumission</a></th><th>lien appel</th><th>titre revue</th><th><a href=\"$url/emrald.php?hceres=hceres\">hceres</a></th><th><a href=\"$url/emrald.php?sjr=sjr\">sjr</a></th><th><a href=\"$url/emrald.php?hIndex=hIndex\">hIndex</a></th><th>recap</th></tr>";

      foreach ($tab as $value) {
        echo "<tr>";
          echo"
          <td>".$value['titreAppel']."</td>
          <td><a href=" . $value["lienAppel"]. ">lien </a></td>
          <td>". $value["datefin"]. "</td>
          <td>". $value['resume'] ."</td>
          <td>". $value['titreRevue'] ."</td>
          <td>". $value['classementHCERES'] ."</td>
          <td>". $value['sjr'] ."</td>
          <td>". $value['hIndex'] ."</td>
          <td><img src=". $value["widgetRecap"] ."></td>
          ";
        echo "</tr>";
      }
  echo "</table>"; //Close the table in HTML
}

function creerTab_aff($str,$op,$result){
  $i = 0;
  $tab=[];
  $q=strtolower(trim(enleverCaracteresSpeciaux($str)));  
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      if(empty($str)){     
             $tab[$i] = array(
                      'titreAppel'       => $row['titreAppel'],
                      'lienAppel'        => $row['lien'],
                      'datefin'          => $row['dateFinSoumission'],
                      'resume'           => $row['resume'],
                      'idRevue'          => $row['idRevue'],
                      'titreRevue'       => $row['titreRevue'],
                      'classementHCERES' => $row['classementHCERES'],
                      'sjr'              => $row['sjr'],
                      'hIndex'           => $row['hIndex'],
                      'widgetRecap'      => $row['widgetRecap']);
      }else{
          if (mb_substr_count(strtolower(enleverCaracteresSpeciaux($row[$op])), $q) >0)
          {
            $tab[$i] = array(
                        'titreAppel'       => $row['titreAppel'],
                        'lienAppel'        => $row['lien'],
                        'datefin'          => $row['dateFinSoumission'],
                        'resume'           => $row['resume'],
                        'idRevue'          => $row['idRevue'],
                        'titreRevue'       => $row['titreRevue'],
                        'classementHCERES' => $row['classementHCERES'],
                        'sjr'              => $row['sjr'],
                        'hIndex'           => $row['hIndex'],
                        'widgetRecap'      => $row['widgetRecap']);
            }
      }
      $i++;
    }
return $tab;
}

function array_sort($array, $on, $order=SORT_ASC) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

  //$tab = creerTab($result);
  if(isset($_GET['ftext']) && isset($_GET['op']))
      $tab = creerTab_aff($_GET['ftext'],$_GET['op'],$result);
  else{
    $tab = creerTab_aff(NULL,NULL,$result);
    echo 'Il faut cocher !';
  }

  echo "<pre>";
  //var_dump($tab);
  if(isset($_GET['hIndex'])){                   afficheTab(array_sort($tab, 'hIndex', SORT_DESC));}
  elseif(isset($_GET['dateFinSoumission'])){    afficheTab(array_sort($tab, 'datefin', SORT_DESC));}
  elseif(isset($_GET['sjr'])){                  afficheTab(array_sort($tab, 'sjr', SORT_DESC));}
  elseif(isset($_GET['hceres'])){               afficheTab(array_sort($tab, 'classementHCERES', SORT_ASC));}
  else{    afficheTab($tab);   }
  echo "</pre>";

$conn = null;

?>
