<?php
require 'db.php';

// Activer l'affichage des erreurs PHP

header('Content-Type: application/json');  // Assurez-vous que la réponse est bien du JSON

// Vérifier que la méthode HTTP est bien POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que les champs requis existent dans $_POST
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['ufr'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $ufr = $_POST['ufr'];
        $bonus = isset($_POST['bonus']) && $_POST['bonus'] === 'true' ? 1 : 0;

        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT * FROM users WHERE firstName = ? AND lastName = ?");
            $stmt->execute([$firstName, $lastName]);
            $existingUser = $stmt->fetch();

            // Si l'utilisateur existe déjà, renvoyer une erreur 400
            if ($existingUser) {
                http_response_code(400);
                echo json_encode(["message" => "Cet utilisateur existe déjà."]);
                exit();  // S'assurer que l'exécution s'arrête ici
            } else {
                // Insérer un nouvel utilisateur
                $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, ufr, bonus) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$firstName, $lastName, $ufr, $bonus])) {
                    http_response_code(201);  // Statut 201 : Ressource créée
                    echo json_encode(["message" => "Utilisateur ajouté avec succès"]);
                    exit();  // S'assurer que l'exécution s'arrête ici
                } else {
                    throw new Exception("Erreur lors de l'ajout de l'utilisateur.");
                }
            }
        } catch (Exception $e) {
            http_response_code(500);  // Statut 500 : Erreur interne du serveur
            echo json_encode(["message" => $e->getMessage()]);
            exit();  // S'assurer que l'exécution s'arrête ici
        }
    } else {
        // Si les données sont incomplètes, renvoyer une erreur 400
        http_response_code(400);
        echo json_encode(["error" => "Données incomplètes. Tous les champs sont requis."]);
        exit();  // S'assurer que l'exécution s'arrête ici
    }
} else {
    // Si la méthode n'est pas POST, renvoyer une erreur 405
    http_response_code(405);  // Statut 405 : Méthode non autorisée
    echo json_encode(["error" => "Méthode non autorisée"]);
    exit();  // S'assurer que l'exécution s'arrête ici
}
?>
