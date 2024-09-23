<?php
$enigmes = [
    1 => ["enigmeid" => "Lieu 1/5 :", "question" => "16.224196, -61.528309", "reponse" => "Dépistage"],
    2 => ["enigmeid" => "Lieu 2/5 :", "question" => "C'est ici que les connaissances se dévoilent...", "reponse" => "Solidarité"],
    3 => ["enigmeid" => "Lieu 3/5 :", "question" => "Bouger, transpirer...", "reponse" => "Prévention"],
    4 => ["enigmeid" => "Lieu 4/5 :", "question" => "Ce lieu porte le nom d’un médecin engagé...", "reponse" => "Mammographie"],
    5 => ["enigmeid" => "Lieu 5/5 :", "question" => "Ce lieu porte le nom d'un docteur...", "reponse" => "Ruban"],
];

header('Content-Type: application/json');  // Assurez-vous que la réponse est bien du JSON

// Gestion des requêtes GET pour afficher l'énigme
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = intval($_GET['id']);
    
    if (isset($enigmes[$id])) {
        echo json_encode($enigmes[$id]);
    } else {
        http_response_code(404); // Énigme non trouvée
        echo json_encode(["error" => "Énigme non trouvée."]);
    }
}
// Gestion des requêtes POST pour valider une réponse
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['reponse'])) {
        $id = intval($_GET['id']);
        $reponse = strtolower(trim($data['reponse']));

        if (isset($enigmes[$id])) {
            if (strtolower($enigmes[$id]['reponse']) === $reponse) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Énigme non trouvée."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Réponse non fournie."]);
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(["error" => "Méthode non autorisée"]);
}
