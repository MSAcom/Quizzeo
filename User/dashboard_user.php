<?php
session_start();


if (!isset($_SESSION['identifiant'])) { // Vérifie si l'utilisateur est connecté
    header("Location: ../accueil/connexion.php"); // Redirige lutilisateur vers page de connexion si pas connecté
    exit();
}

//Permet de vérifier facilement le role de chaque utilisateur
$csvFile = '../accueil/utilisateurs.csv'; // Chemin fichier CSV
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
    
    header("Location: connexion.php"); //redirection
    exit();
}

// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>

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
        <a href="../quizz/reponsequizz/historique.php" class="desktopMenuListItem">Historique</a>
        <a href="../accueil/commentaires.php" class="desktopMenuListItem">Commentaire</a>
            <a href="../accueil/profil.php" class="desktopMenuListItem">Profil</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <h1> Les Quizz présents sur Quizzeo </h1>
        <div class="page">
            <?php
            $quizz_file = fopen("../quizz/creationquizz/quizz.csv", "r");
            $en_tete = fgetcsv($quizz_file); 

            $col_id_quizz = array_search('idquizz', $en_tete);
            $col_nom_quizz = array_search('nomquizz', $en_tete);
            $col_description_quizz = array_search('descriptionquizz', $en_tete);
            $col_actif = array_search('actif', $en_tete);
            $col_status = array_search('status', $en_tete);

            while (($quizz_data = fgetcsv($quizz_file)) !== FALSE) {
                if ($quizz_data[$col_status] === "Lancé" /*|| $quizz_data[$col_status] === "Terminé"*/) { //n'affiche que les quizz qui sont lancés ou terminés
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
