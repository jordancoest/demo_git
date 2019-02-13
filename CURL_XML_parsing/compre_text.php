<?php
include ("enleverCaracteresSpeciaux.php");
include ("connexpdo.inc.php");
    function chaine_perc($str){
       $tab_des_id = [];
       $i=0;
            $q = strtolower(trim(enleverCaracteresSpeciaux($str)));
            $query = "SELECT idRevue,titreRevue FROM revue ";
            $idcom = connexpdo("projet2jpbanj_bdd");            
            $result = $idcom->query($query);   
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {        
                    similar_text($q, strtolower(enleverCaracteresSpeciaux($row['titreRevue'])), $perc);
                    if($perc > 80){
                        $tab_des_id[$i] = array('idRevue'=>$row['idRevue'],'titreRevue'=>$row['titreRevue'],'perc'=>round($perc,2));   
                        $i++; 
                    }
                }   
                return $tab_des_id;           
            $idcom = null;
            
    }
?>
