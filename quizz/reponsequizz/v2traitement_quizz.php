<?php
session_start();
//var_dump($_POST); //pour debuger, affiche toutes les donnees reçues en post

$id_quizz = $_POST["id_quizz"];
$total = $_POST["total"]; //on recupere le score si tout est bon (score maximal)
$score = 0; // Initialisation du score

// Lire les reponses envoyees par l'utilisateur
foreach ($_POST as $key => $value) {
   
    // Verifier si la cle correspond à un champ de réponse
    if (strpos($key, 'id_reponse_validee_') !== false) {
        // Extraire l'identifiant de la question à partir de la cle
        $question_id = substr($key, 19); //on enlève id_reponse_validee_ dans la variable reçue en post
        
        $file_name_reponses = '../creationquizz/reponses_quizz.csv';
        $file_reponses = fopen($file_name_reponses, 'r');
        $en_tete_reponses = fgetcsv($file_reponses);

        while (($ligne_reponses = fgetcsv($file_reponses)) !== false) {
            
            if ($ligne_reponses[0] === $id_quizz && $ligne_reponses[1] === $question_id && $ligne_reponses[4] === 'True') {
           
               /*-----------on ouvre le fichier des questions -----------*/

                $file_name = '../creationquizz/questions_quizz.csv';
                $file = fopen($file_name, 'r');
               
               
                $en_tete_question = fgetcsv($file);
               
                /*on prend les données necessaires dans le fichier des reponses*/
                $col_id_quizz = array_search('id_quizz', $en_tete_reponses);
                $col_id_question = array_search('id_question', $en_tete_reponses);  
                $col_points_question = array_search('points', $en_tete_reponses);

                /*on prend les données necessaires dans le fichier des questions*/
                $col_id_quizz = array_search('id_quizz', $en_tete_question);
                $col_id_question = array_search('id_question', $en_tete_question);  
                $col_id_reponse = array_search('points', $en_tete_question);
 
                
                
                while (($ligne = fgetcsv($file)) !== false) { //on parcours le fichier des questions

                    if ($ligne[$col_id_quizz] == $id_quizz && $ligne[$col_id_question] == $question_id ) { //si l'id_quizz de la ligne correspond au quizz que l'utilisateur à choisis
                        $points_question = $ligne[4];  // on ajoute les points de la question au score
                        if ($_POST["id_reponse_validee_".$ligne_reponses[1]] === $ligne_reponses[2]) { //si la reponse validee est bonne
                            $score += $points_question; 
                        }

                   
                    
                    }
                }
                    
            }
        }
       
        fclose($file_reponses);
        //fclose($file);
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
        <h1 class="titre"><?php echo $_POST["nom_quizz"] ?> </h1>
        <h2><?php echo $_POST["description_quizz"] ?></h2>
        <div>
            <?php
            // Afficher les résultats
            echo "<h1>Résultats du quizz</h1>";
            echo "<p>Votre score est de $score / $total </p>";
            ?>
            <a href='../../User/dashboard_user.php'>Retour</a>
        </div>
    </div>
</div>

</body>
</html>
