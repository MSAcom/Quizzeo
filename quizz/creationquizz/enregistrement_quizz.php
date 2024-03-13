<?php
session_start();

// Vérification de l'authentification de l'utilisateur
if (!isset($_SESSION['identifiant'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupération de l'identifiant de l'utilisateur depuis la session
$id_createur = $_SESSION['id_utilisateur'];

// Vérification des valeurs POST
if (isset($_POST["nom_quizz"], $_POST["questions"], $_POST["reponses"], $_POST["correct_responses"], $_POST["points"])) {
    // Initialisation des valeurs pour le quizz
    $id_quizz = uniqid(); // On définit un ID unique pour chaque nouveau quizz
    $nom_quizz = $_POST["nom_quizz"];
    $description_quizz = $_POST["description_quizz"];
    $actif = "True";
    $status = "EnCours";
    $nb_reponses = 0;
    $url = "url";

    // Ouvrir le fichier quizz.csv en mode ajout
    $file_name = 'quizz.csv';
    $file = fopen($file_name, 'a');

    // Écrire les informations du quizz dans le fichier CSV
    if (filesize($file_name) == 0) {
        fputcsv($file, ['id_quizz', 'nomquizz','descriptionquizz', 'id_utilisateur', 'actif', 'status', 'nb_reponses', 'url']);
    }
    fputcsv($file, [$id_quizz, $nom_quizz, $description_quizz , $id_createur, $actif, $status, $nb_reponses, $url]);

    // Fermer le fichier quizz.csv
    fclose($file);

    // Ouvrir les fichiers questions_quizz.csv et reponses_quizz.csv en mode ajout
    $file_name_questions = 'questions_quizz.csv';
    $file_name_reponses = 'reponses_quizz.csv';
    $file_questions = fopen($file_name_questions, 'a');
    $file_reponse = fopen($file_name_reponses, 'a');

    if (filesize($file_name_questions) == 0) {
        fputcsv($file_questions, ['id_quizz', 'id_question','id_utilisateur', 'question', 'points']);
    }
    
    if (filesize($file_name_reponses) == 0) {
        fputcsv($file_reponse, ['id_quizz', 'id_question','id_reponse', 'reponse', 'bonne_reponse', "nb_reponse"]);
    }
    // Écrire les questions et les réponses dans les fichiers CSV
    foreach ($_POST["questions"] as $questionIndex => $question) {
        $id_question = uniqid();
        $point = $_POST["points"][$questionIndex];

        fputcsv($file_questions, [$id_quizz, $id_question, $id_createur, $question, $point]);

        foreach ($_POST["reponses"][$questionIndex + 1] as $index_reponse => $reponse) {
            $id_reponse = uniqid();
            $bonne_reponse = ($_POST["correct_responses"][$questionIndex + 1] == ($index_reponse + 1)) ? "True" : "False";
            fputcsv($file_reponse, [$id_quizz, $id_question, $id_reponse, $reponse, $bonne_reponse, $nb_reponses]);
        }
    }

    // Fermer les fichiers questions_quizz.csv et reponses_quizz.csv
    fclose($file_questions);
    fclose($file_reponse);

    // Redirection après traitement
    header("Location: creationquizz.php");
    exit();
} else {
    // Gérer le cas où les données POST ne sont pas définies
    echo "Les données POST ne sont pas définies.";
}
?>
