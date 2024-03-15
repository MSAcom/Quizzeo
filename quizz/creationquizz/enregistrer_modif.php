<?php
session_start();


if (!isset($_SESSION['identifiant'])) {// Vérifier si l'utilisateur est connecté
    
    header("Location: connexion.php");// Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}


if (!isset($_POST['id_quizz'])) {
    
    header("Location: ../dashboard/info_quizz.php");// Rediriger l'utilisateur vers une page d'erreur si pas d'id pour le quizz
    exit();
}


$id_quizz = $_POST['id_quizz'];// Récupérer l'ID du quizz à envoyé sur la page précédente avec POST

// Comparer l'ID avec le CSV du quizz
$quizz_file = fopen("quizz.csv", "r+"); // Ouvrir quizz en mode lecture et écriture
$en_tete_quizz = fgetcsv($quizz_file); // Ne pas prendre en compte l'en-tête du fichier csv

$col_id_quizz = array_search('id_quizz', $en_tete_quizz); // Rechercher la colonne nommée id_quizz
$col_nom_quizz = array_search('nomquizz', $en_tete_quizz);// pareil pour le nom du quizz
$col_description_quizz = array_search('descriptionquizz', $en_tete_quizz); // et sa description


if ($col_id_quizz !== false) {// Vérifier l'ID du quizz
    $quizz_details = []; // On crée un tableau pour stocker les details du quizz

    
    $quizz_data = [];
    // On Parcoure les lignes du fichier CSV pour chercher les détails du quizz correspondant à l'ID
    while (($row = fgetcsv($quizz_file)) !== false) {
        if ($row[$col_id_quizz] == $id_quizz) {
            // On met à jour les détails du quizz avec les données du formulaire
            $row[$col_nom_quizz] = isset($_POST['nom_quizz']) ? $_POST['nom_quizz'] : $row[$col_nom_quizz];
            $row[$col_description_quizz] = isset($_POST['description_quizz']) ? $_POST['description_quizz'] : $row[$col_description_quizz];
        }
        $quizz_data[] = $row;
    }

    // On réécris tout dans le csv
    rewind($quizz_file);
    fputcsv($quizz_file, $en_tete_quizz); // même avec l'en tete
    foreach ($quizz_data as $row) {
        fputcsv($quizz_file, $row); // on réécris la ligne
    }

    fclose($quizz_file);

 
    header("Location: creationquizz.php");
    exit();
} else {
    // Si on ne trouve pas l'ID du quizz on redirige vers une page d'erreur
    header("Location: ../dashboard/info_quizz.php");
    exit();
}



// On ouvre les fichiers
$questions_file = fopen("questions_quizz.csv", "r+");
$reponses_file = fopen("reponses_quizz.csv", "r+");

//on parcours les questions
while (($question_row = fgetcsv($questions_file)) !== false) {
    if ($question_row[0] == $id_quizz) {
        // on met à jour ces questions
        $question_row[3] = isset($_POST['questions'][$question_row[1]]) ? $_POST['questions'][$question_row[1]] : $question_row[3]; 
        fputcsv($questions_file, $question_row);

        // On reinitialise le fichier des reponses a sa position de départ
        rewind($reponses_file);

        // ON parcour les réponses
        while (($reponse_row = fgetcsv($reponses_file)) !== false) {
            if ($reponse_row[1] == $question_row[1]) { // Index 1 correspond à l'id de la question
                // On met a jour la reponse si elle appartient à la reponse actuelle
                $reponse_row[3] = isset($_POST['reponses'][$question_row[1]][$reponse_row[2]]) ? $_POST['reponses'][$question_row[1]][$reponse_row[2]] : $reponse_row[3]; // Index 2 correspond à l'id de la réponse
                $reponse_row[4] = isset($_POST['bonne_reponse'][$question_row[1]]) && $_POST['bonne_reponse'][$question_row[1]] == $reponse_row[3] ? 'True' : 'False'; // Vérifie si cette réponse est la bonne réponse
                fputcsv($reponses_file, $reponse_row);
            }
        }
    }
}


fclose($questions_file);
fclose($reponses_file);


header("Location: ../dashboard/dashboard.php");
exit();
?>