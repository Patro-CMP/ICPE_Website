<?php
$host="localhost";
$db_name="icpe_database";
$user="root";
$pwd="";
try {
    $connex=new PDO("mysql:host=$host;dbname=$db_name", $user,$pwd);
    $connex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion ".$e->getMessage());
}
?>