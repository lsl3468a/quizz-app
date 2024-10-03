<?php
$enigmes = [
    1 => ["enigmeid" => "Lieu 1/5 :", "question" => "16.224196, -61.528309", "reponse" => "Dépistage"],
    2 => ["enigmeid" => "Lieu 2/5 :", "question" => "C'est ici que les connaissances se dévoilent et que les esprits curieux viennent se nourrir. Tout comme pour prendre soin de son corps, il est essentiel de s'informer. Surtout avant un examen…", "reponse" => "Solidarité"],
    3 => ["enigmeid" => "Lieu 3/5 :", "question" => "Bouger, transpirer, se dépenser… Ici, le corps est en mouvement, on l'entretient pour qu'il reste fort. C'est aussi un moyen de réduire les risques de cette maladie, car un corps en forme est un allié de taille.", "reponse" => "Prévention"],
    4 => ["enigmeid" => "Lieu 4/5 :", "question" => "Ce lieu porte le nom d’un médecin engagé, figure importante dans le domaine de la santé en Guadeloupe. Son dévouement pour la médecine et l’éducation a marqué de nombreuses générations. Aujourd'hui, ce lieu continue d’accueillir les futurs professionnels de la santé, pour des cours décisifs dans leur parcours. Il symbolise à la fois l’apprentissage et l'héritage d’un homme dont la contribution à la médecine reste gravée dans l’histoire.", "reponse" => "Mammographie"],
    5 => ["enigmeid" => "Lieu 5/5 :", "question" => "Ce lieu porte le nom d'un docteur guadeloupéen de renom, ayant marqué l’histoire par sa lutte incontestable contre la drépanocytose. C’est ici que des générations d'étudiants ont écouté des discours inspirants et appris à repousser les frontières du savoir. Que ce soit pour des cours magistraux ou des événements majeurs, cet espace est un véritable temple du savoir. Son nom est gravé dans la mémoire de notre campus.", "reponse" => "Ruban"],
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
