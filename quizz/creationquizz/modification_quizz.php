<?php
session_start();


if (!isset($_SESSION['identifiant'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Vérifier si on a bien reçu un id avec la POST
if (!isset($_POST['id_quizz'])) {
    //rediriger vers une page d'erreur si on a rien reçu
    header("Location: ../dashboard/info_quizz.php");
    exit();
}

$id_quizz = $_POST['id_quizz'];

/*-----------------nous comparons l'id_quizz avec ceux dans le du quizz-------------------*/
$quizz_file = fopen("quizz.csv", "r"); // nous ouvrons le fichier des quizz en lecture
$en_tete_quizz = fgetcsv($quizz_file); 

$col_id_quizz = array_search('id_quizz', $en_tete_quizz); // nous recherchons les colonnes qui nous interessent dans le fichier quizz.csv
$col_nom_quizz = array_search('nomquizz', $en_tete_quizz);
$col_description_quizz = array_search('descriptionquizz', $en_tete_quizz);
fclose($quizz_file);


if ($col_id_quizz !== false) {
    $quizz_details = []; // on initialise le tableau des détails du quizz

    // on parcours les lignes du fichier CSV pour trouver les détails du quizz correspondant à l'ID fourni
    $quizz_file = fopen("quizz.csv", "r"); // on ouvre à nouveau le fichier des quizz en lecture
    fgetcsv($quizz_file); // on ignore l'en-tête, (la première ligne avec le nom des colonnes)
    while (($row = fgetcsv($quizz_file)) !== false) {
        if ($row[$col_id_quizz] == $id_quizz) {
            // on stocke les détails du quizz dans le tableau
            $quizz_details = $row;
            break; 
        }
    }

    fclose($quizz_file);

    // nous remplissons les champs du formulaire avec les données récupérées
    $nom_quizz = isset($quizz_details[$col_nom_quizz]) ? $quizz_details[$col_nom_quizz] : ""; // entrer le nom du quizz
    $description_quizz = isset($quizz_details[$col_description_quizz]) ? $quizz_details[$col_description_quizz] : ""; // entrer la description du quizz
} else {
    // si l'id du quizz n'est pas trouvé, on redirige l'utilisateur vers une page d'erreur
    header("Location: ../dashboard/info_quizz.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de Quizz</title>
    <link rel="stylesheet" href="creationquizz.css">
</head>
<body>
    <nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="/Projet_final/Quizzeo/accueil/home.php" class="desktopMenuListItem">Home</a>
            <a href="../dashboard/dashboard.php" class="desktopMenuListItem">Dashboard</a>
            <a href="#" class="desktopMenuListItem">Hebergement</a>
            <a href="/Projet_final/Quizzeo/accueil/deconnexion.php" class="desktopMenuListItem">Deconnection</a>
        </div>
    </nav>
    <div class="container">
        <h1>Modification de Quizz </h1>
        <form action="enregistrer_modif.php" method="post" id="question-form">
            <div id="questions-container">
                <div class="question">
                    <div class="center-container">
                        <label for="nom_quizz">Nom du quizz :</label>
                        <input class="nom_quizz" type="text" id="nom_quizz" name="nom_quizz" value="<?php echo htmlspecialchars($nom_quizz); ?>"><!--on remplis le champs du nom du quizz-->
                    </div>
                    <div class="center-container">
                        <label for="description_quizz">Description :</label>
                        <input class="description_quizz" type="text" id="description_quizz" name="description_quizz" value="<?php echo htmlspecialchars($description_quizz); ?>"><!--on remplis le champs description-->
                    </div>
                </div>

               
<?php

$num_question = 1;// on initialise un compteur de question


$question_file = fopen("questions_quizz.csv", "r");
$en_tete_question = fgetcsv($question_file); 
$col_question_id = array_search('id_question', $en_tete_question); // on cherche la colonne de l'id de la question

// on vérifie si l'index de la colonne des questions est valide
if ($col_question_id !== false) {
    $col_question_quizz = array_search('question_quizz', $en_tete_question); // on cherche l'index de la colonne des questions

    // on utilise $col_question_quizz dans votre boucle pour accéder à la colonne des questions
    while (($question_row = fgetcsv($question_file)) !== false) {

        if ($question_row[$col_id_quizz] == $id_quizz) {
            echo "<div class='question'>";

            echo "<h3>Question $num_question</h3>"; // Question :(numéro de la question)
            echo "<input type='text' id='question$num_question' name='questions[]' value='" . htmlspecialchars($question_row[$col_question_quizz]) . "'>";


            echo "<div class='reponses-container'>"; // nous affichons les réponses correspondantes à la question

           /*-------------------reponses--------------------*/
            $reponse_file = fopen("reponses_quizz.csv", "r");
            $en_tete_reponse = fgetcsv($reponse_file); 
            $col_reponse_id = array_search('id_question', $en_tete_reponse); 
            $col_reponse_quizz = array_search('reponse_quizz', $en_tete_reponse); 
            $col_bonne_reponse = array_search('bonne_reponse', $en_tete_reponse); 

            // on parcours les lignes du fichier CSV des réponses
            while (($reponse_row = fgetcsv($reponse_file)) !== false) {
                if ($reponse_row[$col_reponse_id] == $question_row[$col_question_id]) { // on verifie si l'ID de la question correspond à l'ID de la réponse
                    echo "<div>";
                    echo "<input type='text' class='reponse' name='reponses[" . $question_row[$col_question_id] . "][]' value='" . htmlspecialchars($reponse_row[$col_reponse_quizz]) . "'>";/*on remplis le champs reponse du quizz*/
                    echo "<input type='radio' name='bonne_reponse[" . $question_row[$col_question_id] . "]' value='" . htmlspecialchars($reponse_row[$col_reponse_quizz]) . "'";/*on remplis le champs description*/
                    if ($reponse_row[$col_bonne_reponse] == 'True') {
                        echo " checked> Correct";
                    } else {
                        echo ">";
                    }
                    echo "</div>";
                }
            }


            fclose($reponse_file); 

            echo "</div>"; // on ferme la balise des réponses

            echo "</div>"; // on ferme la balise de la question

            $num_question++;// on incremente le compteur
        }
    }
} else {
    // si la colonne n'est pas trouvé
    echo "La colonne des questions n'a pas été trouvée dans le fichier CSV des questions.";
}

fclose($question_file);
?>
</div>

<input type="hidden" name="id_quizz" value="<?php echo $id_quizz; ?>">
<input type="submit" value="Enregistrer les modifications">
</form>
</div>
</body>
</html>