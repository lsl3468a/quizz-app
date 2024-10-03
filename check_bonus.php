<?php
// check_bonus.php
header('Content-Type: application/json');

// Réponse correcte pour la question bonus
$correctAnswer = "1998";

// Récupérer la réponse de l'utilisateur depuis la requête POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['answer'])) {
    // Si aucune donnée ou réponse n'a été envoyée
    echo json_encode(['error' => 'Données invalides']);
    exit();
}

$userAnswer = $data['answer'];

// Comparer la réponse utilisateur avec la bonne réponse
if ($userAnswer === $correctAnswer) {
    echo json_encode(['correct' => true]);
} else {
    echo json_encode(['correct' => false, 'correctAnswer' => $correctAnswer]);
}