<?php
// Vérification des valeurs POST
if(isset($_POST["nom_quizz"], $_POST["questions"], $_POST["reponses"], $_POST["correct_responses"])) {
    // Votre code existant ici

    $id_createur = "moi";
    $id_quizz = uniqid(); // On définit un ID unique pour chaque nouveau quizz
    $nom_quizz = $_POST["nom_quizz"];
    $questions = $_POST["questions"];
    $reponses = $_POST["reponses"];
    $correct_responses = $_POST["correct_responses"];
    $actif = "True";
    $status = "EnCours";
    $nb_reponses = 0;
    $url = "url";

    // Liste pour retenir les ID de toutes les questions
    $questionIds = array();

    // Remplir le fichier quizz.csv
    $file_name = 'quizz.csv'; // Stocke le fichier dans une variable
    $file = fopen($file_name, 'a'); // Ouvre le fichier

    if (filesize($file_name) == 0) { // Si le fichier est vide, mettre à la première ligne le nom des colonnes
        fputcsv($file, ['id_quizz', 'nomquizz', 'id_utilisateur', 'actif', 'status', 'nb_reponses', 'url']);
    }

    // Ajout du quizz
    fputcsv($file, [$id_quizz, $nom_quizz, $id_createur, $actif, $status, $nb_reponses, $url]); // Remplir les champs suivants 

    fclose($file);

    // Remplir le fichier question_quizz.csv
    $file_name_questions = 'questions_quizz.csv'; // Stocke le fichier dans une variable
    $file_questions = fopen($file_name_questions, 'a'); // Ouvre le fichier

    if (filesize($file_name_questions) == 0) { // Si le fichier est vide, mettre à la première ligne le nom des colonnes
        fputcsv($file_questions, ['id_quizz', 'id_question', 'id_utilisateur', 'question']);
    }

    // Remplir le fichier des réponses pour cette question
    $file_name_reponses = 'reponses_quizz.csv'; // Nom du fichier des réponses
    $file_reponse = fopen($file_name_reponses, 'a'); // Ouvre le fichier
    if (filesize($file_name_reponses) == 0) { // Si le fichier est vide, mettre à la première ligne le nom des colonnes
        fputcsv($file_reponse, ['id_quizz', 'id_question', 'id_reponse', 'reponse', 'bonne_reponse', 'nb_reponse']);
    }

    // Ajout des questions et des réponses
    foreach ($questions as $questionIndex => $question) {
        $id_question = uniqid(); // On définit un ID unique pour chaque nouvelle question
        $questionIds[] = $id_question; // Ajouter l'ID de la question à la liste
        // Écriture de chaque question dans le fichier CSV
        fputcsv($file_questions, [$id_quizz, $id_question, $id_createur, $question]);
        
        // Parcourir les réponses en fonction de l'indice de la question
        foreach ($reponses[$questionIndex + 1] as $index_reponse => $reponse) {
            $id_reponse = uniqid(); // On définit un ID unique pour chaque nouvelle réponse
            $bonne_reponse = ($correct_responses[$questionIndex + 1] == ($index_reponse + 1)) ? "True" : "False"; // Vérifie si cette réponse est correcte
            // Écriture de chaque réponse dans le fichier CSV
            fputcsv($file_reponse, [$id_quizz, $id_question, $id_reponse, $reponse, $bonne_reponse, $nb_reponses]);
        }
    }
    fclose($file_questions);
    fclose($file_reponse);

    // Redirection après traitement
    header("Location: creationquizz.php");
    exit; // Arrête l'exécution du script après la redirection
} else {
    // Gérer le cas où les données POST ne sont pas définies
    echo "Les données POST ne sont pas définies.";
}
?>
