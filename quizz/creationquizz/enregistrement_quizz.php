<?php
session_start();


if (!isset($_SESSION['identifiant'])) { // Vérifie si l'utilisateur est connecté
    header("Location: ../../accueil/connexion.php"); // Redirige lutilisateur vers page de connexion si pas connecté
    exit();
}

//Permet de vérifier facilement le role de chaque utilisateur
$csvFile = '../../accueil/utilisateurs.csv'; // Chemin fichier CSV
if (($handle = fopen($csvFile, "r")) !== FALSE) {// Ouvrir le fichier CSV en mode lecture seulement
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //Parcours tant qu'il y'a de lignes
        
        $users[$data[3]] = array( // Crée tableau users et grace à l'identifiant de l'utilisateur, va stocker le role de l'utilisateur
            'role' => $data[4]
        );
    }
    fclose($handle);
}


$identifiant = $_SESSION['identifiant'];
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Entreprise' || isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Ecole') {// Vérifie si l'utilisateur a le rôle "Utilisateur"
    // si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../../accueil/connexion.php"); //redirection
    exit();
}

// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];

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
    fputcsv($file, [$id_quizz, $nom_quizz, $description_quizz , $id_utilisateur, $actif, $status, $nb_reponses, $url]);

    // Fermer le fichier quizz.csv
    fclose($file);

    // Ouvrir les fichiers questions_quizz.csv et reponses_quizz.csv en mode ajout
    $file_name_questions = 'questions_quizz.csv';
    $file_name_reponses = 'reponses_quizz.csv';
    $file_questions = fopen($file_name_questions, 'a');
    $file_reponse = fopen($file_name_reponses, 'a');

    if (filesize($file_name_questions) == 0) {
        fputcsv($file_questions, ['id_quizz', 'id_question','id_utilisateur', 'question_quizz', 'points']);
    }
    
    if (filesize($file_name_reponses) == 0) {
        fputcsv($file_reponse, ['id_quizz', 'id_question','id_reponse', 'reponse_quizz', 'bonne_reponse', "nb_reponse"]);
    }
    // Écrire les questions et les réponses dans les fichiers CSV
    foreach ($_POST["questions"] as $questionIndex => $question) {
        $id_question = uniqid();
        $point = $_POST["points"][$questionIndex];

        fputcsv($file_questions, [$id_quizz, $id_question, $id_utilisateur, $question, $point]);

        foreach ($_POST["reponses"][$questionIndex + 1] as $index_reponse => $reponse) {
            $id_reponse = uniqid();
            $bonne_reponse = ($_POST["correct_responses"][$questionIndex + 1] == ($index_reponse + 1)) ? "True" : "False";
            fputcsv($file_reponse, [$id_quizz, $id_question, $id_reponse, $reponse, $bonne_reponse, $nb_reponses]);
        }
    }

    // on ferme les fichiers questions_quizz.csv et reponses_quizz.csv
    fclose($file_questions);
    fclose($file_reponse);

    if ($users[$identifiant]['role'] === "Ecole"){
    header("Location: ../../Ecole/dashboard_ecole.php");}

    if ($users[$identifiant]['role'] === "Entreprise"){
        header("Location: ../../Entreprise/dashboard_entreprise.php");}
    exit();
} else {
    //si on a pas reçu les données voulues via POST
    echo "Les données POST ne sont pas définies.";
}
?>
