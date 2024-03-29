<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: ../../accueil/connexion.php");
    exit();
}

// Récupérer l'identifiant de l'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];

// Récupérer les données envoyées en POST
$id_quizz = $_GET["id_quizz"];

/*--------------QUIZZ---------------*/
// Ouvrir le fichier des questions
$quizz_file_name = '../creationquizz/quizz.csv';
$quizz_file = fopen($quizz_file_name, 'r');

// Lire la première ligne pour obtenir les en-têtes des colonnes
$en_tete_quizz = fgetcsv($quizz_file);

// Chercher les index des colonnes nécessaires
$col_id_quizz = array_search('id_quizz', $en_tete_quizz); 
$col_nom_quizz= array_search('nomquizz', $en_tete_quizz); 
$col_description_quizz = array_search('descriptionquizz', $en_tete_quizz); 
// Parcourir le fichier pour trouver le quiz correspondant à l'ID
while (($ligne_quizz = fgetcsv($quizz_file)) !== false) {
    if ($ligne_quizz[$col_id_quizz] == $id_quizz) {
        $nom_quizz = $ligne_quizz[$col_nom_quizz];
        $description_quizz = $ligne_quizz[$col_description_quizz];
    }}
fclose($quizz_file);
/*--------------------QUESTIONS------------------*/
// Ouvrir le fichier des questions
$file_name = '../creationquizz/questions_quizz.csv';
$file = fopen($file_name, 'r');

// Lire la première ligne pour obtenir les en-têtes des colonnes
$en_tete_question = fgetcsv($file);

// Chercher les index des colonnes nécessaires
$col_id_quizz = array_search('id_quizz', $en_tete_question); 
$col_id_question = array_search('id_question', $en_tete_question); 
$col_question = array_search('question_quizz', $en_tete_question); 
$col_points_question = array_search('points', $en_tete_question);

// Ouvrir le fichier des réponses
$file_name_reponses = '../creationquizz/reponses_quizz.csv';
$file_reponses = fopen($file_name_reponses, 'r');

// Lire la première ligne pour obtenir les en-têtes des colonnes
$en_tete_reponses = fgetcsv($file_reponses);

// Chercher les index des colonnes nécessaires
$col_id_quizz_fichier_reponse = array_search('id_quizz', $en_tete_reponses); 
$col_id_question_fichier_reponse = array_search('id_question', $en_tete_reponses); 
$col_id_reponse_fichier_reponse = array_search("id_reponse", $en_tete_reponses);
$col_reponse_fichier_reponse = array_search('reponse_quizz', $en_tete_reponses); 
$col_bonne_reponse = array_search("bonne_reponse", $en_tete_reponses);
$col_id_reponse = array_search('id_reponse', $en_tete_reponses);
$points_totaux = 0; // Initialisation du score

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
    
    <link rel="stylesheet" href="../../quizz/dashboard/dashboard.css">
    <link rel="stylesheet" href="quizz.css">
</head>
<body>
<nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="../../User/dashboard_user.php" class="desktopMenuListItem">Quizz</a>
            <a href="historique.php" class="desktopMenuListItem">Historique</a>
            <a href="../../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <div class="logodiv">
            <img class="logo" src="../images/quizzeo-sans-fond.png">
        </div>
        <div class="entete">
        <h1 class="titre"><?php echo $nom_quizz ?></h1>
        <h2><?php echo $description_quizz ?></h2>
        </div>
        <form action="traitement_quizz.php" method="post">
            <div class="question"><?php


                while (($ligne = fgetcsv($file)) !== false) { // parcourir le fichier des questions
                    if ($ligne[$col_id_quizz] == $id_quizz) { // si l'id_quizz de la ligne correspond au quizz choisi par l'utilisateur
                        // afficher les informations de la question
                        $id_question = $ligne[$col_id_question]; // Stocker l'id de la question
                        $points_question = $ligne[$col_points_question];
                        $points_totaux +=  $points_question;
                        ?><input type="hidden" name="question<?php echo $id_question; ?>" value="<?php echo $ligne[$col_question] ?>"><?php
                        echo "<p> Question : " . $ligne[$col_question] . "<br>"; // on affiche la question
                        echo "Points attribués à la question : " . $ligne[$col_points_question] . "</p><br>"; // on affiche les points attribués à cette question
                        rewind($file_reponses); // Revenir au début du fichier des réponses
                        while (($ligne_reponses = fgetcsv($file_reponses)) !== false) { // on parcours le fichier des reponses
                            // si l'id_question correspondant à la réponse correspond à celui stocké précédemment
                            if ($ligne_reponses[$col_id_quizz_fichier_reponse] === $id_quizz && $ligne_reponses[$col_id_question_fichier_reponse] === $id_question) {
                                if (isset($ligne_reponses[$col_reponse_fichier_reponse])) { // si les données sont présentes
                                    ?>
                                    <label> <!--on affiche la reponse dans le formulaire -->
                                 
                                        <input type="radio" name="id_reponse_validee_<?php echo $id_question; ?>" value="<?php echo $ligne_reponses[$col_id_reponse_fichier_reponse]; ?>"> 
                                        <?php echo $ligne_reponses[$col_reponse_fichier_reponse]?></label><br>
                                         <input type="hidden" name="points<?php echo $id_question; ?>" value="<?php echo $points_question ?>">
                                        
                                    <?php
                                    
                                    
                                }
                            }
                        }
                    }
                }
               
                fclose($file); // on ferme les fichiers
                fclose($file_reponses);
                ?> 
                <input type="hidden" name="nom_quizz" value="<?php echo $nom_quizz ?>">
                <input type="hidden" name="description_quizz" value="<?php echo $description_quizz ?>">
                <input type="hidden" name="id_quizz" value="<?php echo $id_quizz ?>">
                <input type="hidden" name="total" value="<?php echo $points_totaux ?>">
            
            <input class ="soumettre" type="submit" value="Soumettre">
        </form>
    </div></div>


</body>
</html>
