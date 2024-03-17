<?php
session_start();
 

$id_quizz = $_POST["id_quizz"];
$total = $_POST["total"]; //on recupere le score si tout est bon (score maximal)
$score = 0; // Initialisation du score
 
// Lire les reponses envoyees par l'utilisateur
foreach ($_POST as $key => $value) {
    // Verifier si la cle correspond à un champ de réponse
    if (strpos($key, 'question') !== false) {
        // Extraire l'identifiant de la question à partir de la cle
        $question_id = substr($key, 8);
        echo $question_id;
        
        $file_name_reponses = '../creationquizz/reponses_quizz.csv';
        $file_reponses = fopen($file_name_reponses, 'r');
       
        while (($ligne_reponses = fgetcsv($file_reponses)) !== false) {
            
            if ($ligne_reponses[0] === $id_quizz && $ligne_reponses[1] === $question_id && $ligne_reponses[4] === 'True') {
               
               
                
               
                $file_name = '../creationquizz/questions_quizz.csv';
                $file = fopen($file_name, 'r');
               
               
                $en_tete_question = fgetcsv($file);
               
                
                $col_id_quizz = array_search('id_quizz', $en_tete_question);
                $col_id_question = array_search('id_question', $en_tete_question);  
                $col_points_question = array_search('points', $en_tete_question);
                while (($ligne = fgetcsv($file)) !== false) { //on parcours le fichier des questions
                    if ($ligne[$col_id_quizz] == $id_quizz && $ligne[$col_id_question] == $question_id ) { //si l'id_quizz de la ligne correspond au quizz que l'utilisateur à choisis
                    // on ajoute les points de la question au score
                    $points_question = $ligne[4];
                    }
                }
                    $score += $points_question; 
            }
        }
       
        fclose($file_reponses);
    }
}
 

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
        <h1 class="titre">nomduquizz</h1>
        <h2>description</h2>
        <div>
            <?php
            // Afficher les résultats
            echo "<h1>Résultats du quizz</h1>";
            echo "<p>Votre score est de $score / $total</p>";
            ?>
            <a href='../../User/dashboard_user.php'>Retour</a>
        </div>
    </div>
</div>

</body>
</html>
