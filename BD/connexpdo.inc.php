<?php
require_once 'erreur.php';
// string $db : nom de la base de données à laquelle se connecter
function connexpdo(string $db)
{
    $sgbd = "mysql"; // choix de MySQL
    $host = "mysql-projet2jpbanj.alwaysdata.net";
    $charset = "UTF8";
    $user = "176186"; // identifiant utilisateur
    $pass = "projetBANJ"; // mot de passe
    try {
        $pdo = new PDO("$sgbd:host=$host;dbname=$db;charset=$charset", $user , $pass);
        // force le lancement d'exception en cas d'erreurs d'exécution de requêtes SQL
        // via eg. $pdo->query()
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        displayException($e);
        exit;
    }
}
?>
