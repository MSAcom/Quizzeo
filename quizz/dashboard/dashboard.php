<?php
session_start();


if (!isset($_SESSION['identifiant'])) {
    
    header("Location: ../../accueil/connexion.php");// Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}


$id_utilisateur = $_SESSION['id_utilisateur'];// Récupérer l'id de l'utilisateur à partir de la session
$identifiant = $_SESSION['identifiant'];//on récupère aussi l'identifiant
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page quizzs</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="card.css">
</head>
<body>
    <nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="../creationquizz/creationquizz.php" class="desktopMenuListItem">Créer un quizz</a>
            <a href="./pagefavoris.php" class="desktopMenuListItem">Favoris</a>
            <a href="../../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <h1> Les Quizz de  <?php echo $identifiant ?> : </h1>
        <div class="page">
            <?php

            
            $quizz_file = fopen("../creationquizz/quizz.csv", "r");
            $en_tete = fgetcsv($quizz_file); 
            

            $col_id_quizz = array_search('idquizz', $en_tete);// on cherche les colonnes dans le csv
            $col_nom_quizz = array_search('nomquizz', $en_tete);
            $col_description_quizz = array_search('descriptionquizz', $en_tete);
            $col_utilisateur = array_search('id_utilisateur', $en_tete);
            $col_actif = array_search('actif', $en_tete);
            $col_status = array_search('status', $en_tete);
            $col_nb_reponses = array_search('nb_reponses', $en_tete);
            $col_url = array_search('url', $en_tete);


            while (($quizz_data = fgetcsv($quizz_file)) !== FALSE) {// Afficher chaque quizz créé par l'utilisateur
                if ($quizz_data[$col_utilisateur] == $id_utilisateur) {
                    ?>
                    <div class="tableau">
                        <div class="card">
                            <div class='texte'>nom : <?php echo $quizz_data[$col_nom_quizz]; ?></div>
                            <div class='description'>description : <?php echo $quizz_data[$col_description_quizz]; ?></div>
                            <div class='description'>status : <?php echo $quizz_data[$col_status]; ?></div>
                            <div class='description'>nombre de réponses : <?php echo $quizz_data[$col_nb_reponses]; ?></div>
                            <form action="reception.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
                                <input type="hidden" name="statut" value="<?php echo $quizz_data[$col_status]; ?>">
                                <button type="submit">infos</button>
                            </form>
                            <div class="button-container">
                                <form action="reprendre_quizz.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
                                    <input type="hidden" name="statut" value="<?php echo $quizz_data[$col_status]; ?>">
                                    <input type="hidden" name="nom" id ="nom" value="<?php echo $quizz_data[$col_nom_quizz]; ?>">
                                    <input type="hidden" name="description" value="<?php echo $quizz_data[$col_description_quizz]; ?>">
                                    <button type="submit">modifier</button>
                                </form>
                                <?php if ($quizz_data[$col_status] !== "Lancé") { ?>
                                    <form action="lancer_quizz.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
                                        <input type="hidden" name="statut" value="<?php echo $quizz_data[$col_status]; ?>">
                                        <button type="submit">lancer</button>
                                    </form>
                                <?php } ?>
                                <?php if ($quizz_data[$col_status] !== "Terminé") { ?>
                                    <form action="terminer_quizz.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
                                        <input type="hidden" name="statut" value="<?php echo $quizz_data[$col_status]; ?>">
                                        <button type="submit">terminer</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }

            fclose($quizz_file);
            ?>
        </div>
    </div>
</body>
</html>
