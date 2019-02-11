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
        $sql = "SELECT issn,titre,cat,cnrs,fnege,hceres FROM revues";
        $result = $conn->query($sql);
        //echo "$result";
        echo "<br>";
        echo "<h1> <strong> Listes des Revues </strong> : </h1> ";
        echo "<br>";


        if ($result->num_rows > 0) {
            echo "<table> <tr> <th>ISSN</th> <th>Titre</th> <th>Cat</th>  <th>cnrs</th>  <th>fnege</th>  <th>hceres</th> </tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["issn"]."</td><td>".$row["titre"]." </td><td>".$row["cat"]."</td><td>".$row["cnrs"]."</td><td>".$row["fnege"]."</td><td>".$row["hceres"]."</td>             </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }



    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(file) . '/log_error_php.txt');
   //Reading XML using the SAX(Simple API for XML) parser
   //echo "salut";
   $tutors   = array();
   $elements   = null;

   // Called to this function when tags are opened
   function startElements($parser, $name, $attrs) {
      global $tutors, $elements;

      if(!empty($name)) {
         if ($name == 'ITEM') {
            // creating an array to store information
            $tutors []= array();
         }
         $elements = $name;
      }
      // var_dump($elements);
      //echo "<br>";
      //echo $elements;
   }


   // Called to this function when tags are closed
   function endElements($parser, $name) {
      global $elements;

      if(!empty($name)) {
         $elements = null;
      }
   }
// Called on the text between the start and end of the tags
   function characterData($parser, $data) {
      global $tutors, $elements;

      if(!empty($data)) {
         if ($elements == 'TITLE' || $elements == 'LINK' || $elements == 'DESCRIPTION') {
            $tutors[count($tutors)-1][$elements] = trim($data);
         }
      }
   }

   // Creates a new XML parser and returns a resource handle referencing it to be used by the other XML functions.
   $parser = xml_parser_create();

   xml_set_element_handler($parser, "startElements", "endElements");
   xml_set_character_data_handler($parser, "characterData");

   // open xml file
   if (!($handle = fopen('http://www.emeraldgrouppublishing.com/authors/writing/calls.xml', "r"))) {
      die("could not open XML input");
   }

   while($data = fread($handle, 4096)) // read xml file
   {
      xml_parse($parser, $data);  // start parsing an xml document
   }

   xml_parser_free($parser); // deletes the parser
   $i = 1;

    echo "<br>";
   echo "<h1> <strong> Listes des Calls </strong> : </h1> ";
   echo "<br>";
   foreach($tutors as $course) {
       //var_dump($course);
       //echo "<br>";

       foreach ($course as $key => $value) {
           echo "{$key} => {$value} ";
			if ($key == "DESCRIPTION") {
			preg_match("`([0-9]*[a-z]* [a-zA-Z]* [0-9]{4})`", $value, $res_regex);
			if ($res_regex!=NULL) {
				echo "<br>Deadline : ".$res_regex[1];
			}
            $re = '`([zA-Z][* [a-zA-Z]*)`';
			preg_match($re, $value, $res_regex2);
			if ($res_regex!=NULL) {
				echo "<br>Revue : ".$res_regex2[1];
			}
           }
       }

       echo "<br>";
   }
?>
