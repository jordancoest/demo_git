<?php

function connectionBdd($servername, $username, $password, $dbname){
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
  
function requeteBdd($requete){

    if ($conn->query($requete) === TRUE) {
    echo "OK";
    } else {
        echo "Error: " . $requete . "<br>" . $conn->error;
    }   
}

function fermerBdd(){
    $conn->close();
}


?>