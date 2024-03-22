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
    
    header("Location: ../accueil/connexion.php"); //redirection
    exit();
}

// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
// Récupération des quizz déjà joués par l'utilisateur depuis le fichier stockage_reponses.csv
$quizz_deja_joues = [];
$stockage_reponses_file = fopen("../quizz/reponsequizz/stockage_reponses.csv", "r");
while (($reponse_data = fgetcsv($stockage_reponses_file)) !== FALSE) {
    if ($reponse_data[0] == $id_utilisateur) {
        $quizz_deja_joues[] = $reponse_data[1]; // Ajout de l'ID du quizz déjà joué
    }
}
fclose($stockage_reponses_file);
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
        <a href="#" class="desktopMenuListItem">Quizz</a>
        <a href="../accueil/commentaires.php" class="desktopMenuListItem">Commentaire</a>
            <a href="../accueil/profil.php" class="desktopMenuListItem">Profil</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span>User </p>
    </nav>
    <div class="container">
        <h1> Les Quizz présents sur Quizzeo </h1>
        <div> <!--pour qu'on puisse acceder aux quizz via un lien-->
            <div><h2>Vous avez un lien ?</h2></div>

            <div>
                <form class="formurl" action="vers_lien.php" method="get">
                    <label for="url"></label>
                    <input class="url" type="text" id="url" name="url" placeholder="Entrez-le ici !" required>
                    <button class="boutonurl" type="submit">Accéder</button>
                </form>
            </div>

        </div><div><h2>Sinon choisissez un de ces quizz !</h2></div>
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
                if ($quizz_data[$col_status] === "Lancé" && $quizz_data[$col_actif] === "True" && !in_array($quizz_data[$col_id_quizz], $quizz_deja_joues)) { //n'affiche que les quizz qui sont lancés ou terminés
            ?>
               
                <div class="tableau">
                    <div class="card">
                        <div class='texte'>nom : <?php echo $quizz_data[$col_nom_quizz]; ?></div>
                        <div class='description description_quizz'>description : <?php echo $quizz_data[$col_description_quizz]; ?></div>
                        <form action="../quizz/reponsequizz/pagequizzreponse.php" method="get">
                            <input type="hidden" name="id_quizz" value="<?php echo $quizz_data[$col_id_quizz]; ?>">
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
