<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page quizzs</title>
    <link rel="stylesheet" href="../quizz/dashboard/dashboard.css">
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="listeuser.php" class="desktopMenuListItem">Historique</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <h1> Les Quizz présents sur Quizzeo </h1>
        <div class="page">
            <?php
            $quizz_file = fopen("../stockage_reponses.csv", "r");
            $en_tete = fgetcsv($quizz_file); 

            $col_id_quizz = array_search('idquizz', $en_tete);
            $col_note = array_search('score', $en_tete);

            while (($quizz_data = fgetcsv($quizz_file)) !== FALSE) {
                if ($quizz_data[$col_status] === "Lancé" || $quizz_data[$col_status] === "Terminé") { //n'affiche que les quizz qui sont lancés ou terminés
            ?>
                <div class="tableau">
                    <div class="card">
                        <div class='texte'>nom : <?php echo $quizz_data[$col_nom_quizz]; ?></div>
                        <div class='description description_quizz'>description : <?php echo $quizz_data[$col_description_quizz]; ?></div>
                        <form action="../quizz/reponsequizz/pagequizzreponse.php" method="post">
                            <input type="hidden" name="id_quizz" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
                            <input type="hidden" name="nom_quizz" value="<?php echo $quizz_data[$col_nom_quizz]; ?>">
                            <input type="hidden" name="description_quizz" value="<?php echo $quizz_data[$col_description_quizz]; ?>">
                            <button class="jouer" type="submit">Jouer</button>
                        </form>
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
