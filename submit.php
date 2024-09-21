<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $ufr = $_POST['ufr'];
    $bonus = isset($_POST['bonus']) && $_POST['bonus'] === 'true' ? 1 : 0;

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT * FROM users WHERE firstName = ? AND lastName = ?");
    $stmt->execute([$firstName, $lastName]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        http_response_code(400);
        echo json_encode(["message" => "Cet utilisateur existe déjà."]);
    } else {
        // Insérer un nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, ufr, bonus) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$firstName, $lastName, $ufr, $bonus])) {
            http_response_code(201);
            echo json_encode(["message" => "Utilisateur ajouté avec succès"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erreur lors de l'ajout de l'utilisateur."]);
        }
    }
}
?>
