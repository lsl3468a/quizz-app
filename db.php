<?php

$host = 'db5016377320.hosting-data.io'; // Changez-le si votre base de données est ailleurs
$db = 'dbs13312682'; // Remplacez par le nom de votre base de données
$user = 'dbu5561348'; // Nom d'utilisateur MySQL
$password = 'lululas972'; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
