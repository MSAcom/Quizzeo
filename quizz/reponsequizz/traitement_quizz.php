<?php
session_start();



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
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Utilisateur') {// Vérifie si l'utilisateur a le rôle "Utilisateur"
    // Si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../../accueil/connexion.php"); //redirection
    exit();
}

// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];



/*var_dump($_POST);*///pour verifier les données recues en post


$id_utilisateur = $_SESSION['id_utilisateur'];

$id_quizz = $_POST["id_quizz"];
$total = $_POST["total"];
$score = 0;
$nom_du_quizz = $_POST["nom_quizz"];
// on lit les données envoyées par l'utilisateur
foreach ($_POST as $key => $value) {
    if (strpos($key, 'id_reponse_validee_') !== false) {
        //extraire l'identifiant de la question à partir de la clé
        $question_id = substr($key, 19);// on enlève les 19 premiers caracteres de la cle pour ne garder que l'id_question
        
        /*----------------reponses-------------*/
        $file_name_reponses = '../creationquizz/reponses_quizz.csv';
        $file_reponses = fopen($file_name_reponses, 'r');
        $en_tete_reponses = fgetcsv($file_reponses);

        while (($ligne_reponses = fgetcsv($file_reponses)) !== false) {
            if ($ligne_reponses[0] === $id_quizz && $ligne_reponses[1] === $question_id && $ligne_reponses[4] === 'True') {
                /*-----------questions----------------*/
                $file_name = '../creationquizz/questions_quizz.csv';
                $file = fopen($file_name, 'r');
                $en_tete_question = fgetcsv($file);

                // on recupere les données nécessaires dans le fichier des questions
                $col_id_quizz = array_search('id_quizz', $en_tete_question);
                $col_id_question = array_search('id_question', $en_tete_question);  
                $col_points_question = array_search('points', $en_tete_question);

                while (($ligne = fgetcsv($file)) !== false) {
                    if ($ligne[$col_id_quizz] == $id_quizz && $ligne[$col_id_question] == $question_id ) {
                        $points_question = $ligne[4];
                        if ($_POST["id_reponse_validee_".$ligne_reponses[1]] === $ligne_reponses[2]) {
                            $score += $points_question; 
                        }
                    }
                }
                fclose($file);
            }
        }
        fclose($file_reponses);
    }
}

/*--------------inscrire les données dans un fichier csv --------------*/
$file_name_stockage = 'stockage_reponses.csv';
$file_stockage = fopen($file_name_stockage, 'a+');


//si le fichier est vide on ajoute l'en-tete
if (filesize($file_name_stockage) == 0) {
    fputcsv($file_stockage, ['id_utilisateur', 'id_quizz', 'score', 'nom_quizz']);
}

//on cherche si une ligne pour ce quizz existe déjà
$score_updated = false;
$lines = []; //on crée un tableau pour stocker les informations
while (($ligne_stockage = fgetcsv($file_stockage)) !== false) {//on parcours le fichier
    if ($ligne_stockage[0] == $id_utilisateur && $ligne_stockage[1] == $id_quizz) {//si la ligne correspond à la bonne personne et au bon quizz
        $ligne_stockage[2] = $score; //on met à jours le code existant
        $score_updated = true;//on change la variable en true
    }
    $lines[] = $ligne_stockage; // Stocker toutes les lignes pour les réécrire plus tard
}

/*----------on réécrit le fichier------------------*/
ftruncate($file_stockage, 0); // on vide le ficheir existant


//si le fichier est vide, on réécrit l'en-tete
if (filesize($file_name_stockage) == 0) {
    fputcsv($file_stockage, ['id_utilisateur', 'id_quizz', 'score', 'nom_quizz']);
}

foreach ($lines as $line) {
    fputcsv($file_stockage, $line); // reecrire chaque ligne
}

// si l'utilisateur n'a pas déja joué au quizz
if (!$score_updated) {
    fputcsv($file_stockage, [$id_utilisateur, $id_quizz, $score, $nom_du_quizz]); // on ajoute la ligne
}


fclose($file_stockage);

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
            <a href="historique.php" class="desktopMenuListItem">Historique</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>


    <div class="container">
    <div class="logodiv">
        <img class="logo" src="../images/quizzeo-sans-fond.png">
    </div>
    <div class="entete">
        <h1 class="titre"><?php echo $_POST["nom_quizz"] ?> </h1>
        <h2><?php echo $_POST["description_quizz"] ?></h2>
        <div>
            <?php
            // on affiche les resultats
            echo "<h1>Résultats du quizz</h1>";
            echo "<p>Votre score est de $score / $total </p>";
            ?>
            <a href='../../User/dashboard_user.php'>Retour</a>
        </div>
    </div>
</div>

</body>
</html>
