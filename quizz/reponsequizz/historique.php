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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page quizzs</title>
    <link rel="stylesheet" href="../dashboard/dashboard.css">
    <link rel="stylesheet" href="../../User/user.css">
</head>
<body>
    <nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="../../User/dashboard_user.php" class="desktopMenuListItem">Quizz</a>
            <a href="../../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <h1> Les Quizz auquel vous avez déja joué </h1>
        <div class="page">
            <?php
            /*ouvrir le fichier stockage*/ 
            $stockage_file = fopen("stockage_reponses.csv", "r");
            $en_tete = fgetcsv($stockage_file); // Lire et ignorer l'en-tête

            $col_id_quizz_stockage = array_search('id_quizz', $en_tete);
            $col_note = array_search('score', $en_tete);
            $col_nom_quizz = array_search('nom_quizz', $en_tete);

            /*ouvrir le fichier quizz*/
           $quizz_file = fopen("../creationquizz/quizz.csv", "r");
            $en_tete_quizz = fgetcsv($quizz_file); 

            $col_id_quizz = array_search('idquizz', $en_tete_quizz);
            $col_nom = array_search('nom_quizz', $en_tete_quizz);

            while (($stockage_data = fgetcsv($stockage_file)) !== FALSE) {
                // Ignorer l'en-tête
                if ($stockage_data[0] === $en_tete[0]) {
                    continue;
                }

                // Vérifier si l'ID de l'utilisateur correspond à celui stocké dans le fichier
                if ($stockage_data[0] == $id_utilisateur) {
            ?>
                <div class="tableau">
                    <div class="card">
                        <div class='texte'>nom : <?php echo $stockage_data[$col_nom_quizz]; ?></div>
                        <div class='description description_quizz'>note : <?php echo $stockage_data[$col_note]; ?></div>
                    </div>
                </div>
            <?php
                }
            }
            
            fclose($stockage_file);
            fclose($quizz_file);
            ?>
        </div>
    </div>
</body>
</html>
