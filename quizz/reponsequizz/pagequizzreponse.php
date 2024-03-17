<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// recuperer l'identifiant de l'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];

//recuperer les donnees envoyees en post
$id_quizz = $_POST["id_quizz"];
$nom_quizz = $_POST["nom_quizz"];
$description_quizz = $_POST["description_quizz"];

$file_name = '../creationquizz/questions_quizz.csv';
$file = fopen($file_name, 'r');


$en_tete_question = fgetcsv($file);


$col_id_quizz = array_search('id_quizz', $en_tete_question); 
$col_id_question = array_search('id_question', $en_tete_question); 
$col_question = array_search('question_quizz', $en_tete_question); 
$col_points_question = array_search('points', $en_tete_question);

$file_name_reponses = '../creationquizz/reponses_quizz.csv';
$file_reponses = fopen($file_name_reponses, 'r');

$en_tete_reponses = fgetcsv($file_reponses);

$col_id_quizz_fichier_reponse = array_search('id_quizz', $en_tete_reponses); 
$col_id_question_fichier_reponse = array_search('id_question', $en_tete_reponses); 
$col_reponse_fichier_reponse = array_search('reponse_quizz', $en_tete_reponses); 
$col_bonne_reponse = array_search("bonne_reponse", $en_tete_reponses);

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
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="listeuser.php" class="desktopMenuListItem">Utilisateurs</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <div class="logodiv">
            <img class="logo" src="quizzeo.png">
        </div>
        <div class="entete">
        <h1 class="titre"><?php echo $nom_quizz ?></h1>
        <h2><?php echo $description_quizz ?></h2>
        </div>
        <form action="traitement_quizz.php" method="post">
            <div class="question"><?php

                while (($ligne = fgetcsv($file)) !== false) { //on parcours le fichier des questions
                    if ($ligne[$col_id_quizz] == $id_quizz) { //si l'id_quizz de la ligne correspond au quizz que l'utilisateur à choisis
                        // Afficher les informations de la question
                        $id_question = $ligne[$col_id_question]; // on stocke l'id de la question
                        $points_question = $ligne[$col_points_question];
                        $points_totaux +=  $points_question;
                        echo "<p> Question : " . $ligne[$col_question] . "<br>"; // on écrit la question
                        echo "Points attribués à la question : " . $ligne[$col_points_question] . "</p><br>"; //et la description du quizz
                        rewind($file_reponses); // on retourne au debut du fichier des réponses pour le parcourir à nouveau
                        while (($ligne_reponses = fgetcsv($file_reponses)) !== false) { // on parcours le fichier des reponses
                            //si l'id_question correspondant à la reponse correspond à celui stocké précedemment,
                            if ($ligne_reponses[$col_id_quizz_fichier_reponse] === $id_quizz && $ligne_reponses[$col_id_question_fichier_reponse] === $id_question) {
                                if (isset($ligne_reponses[$col_reponse_fichier_reponse])) { //si la données est bien présente
                                    ?>
                                    <label> <!--on écrit la reponse-->
                                        <input type="radio" name="question<?php echo $id_question; ?>" value="<?php echo $ligne_reponses[$col_reponse_fichier_reponse]; ?>"> 
                                           <?php echo $ligne_reponses[$col_reponse_fichier_reponse]?></label>
                                         <input type="hidden" name="points<?php echo $id_question; ?>" value="<?php echo $points_question ?>">

                                        <?php
                                       

                                }
                            }
                        }
                    }
                }
                fclose($file);
                fclose($file_reponses) ?> 
                <input type="hidden" name="total" value="<?php echo $points_totaux ?>">
                <input type="hidden" name="id_quizz" value="<?php echo $id_quizz ?>">
            
            <input class ="soumettre" type="submit" value="Soumettre">
        </form>
    </div></div>


</body>
</html>
