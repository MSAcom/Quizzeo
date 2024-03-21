<?php
session_start();

$csv_file = 'commentaires.csv';

if (!file_exists($csv_file)) { // Si fichier CSV n'existe pas, il écrit les catégories
    $header = array('nom', 'prenom', 'Sujet', 'Commentaire', 'Date de Publication');
    $file_handle = fopen($csv_file, 'w');
    fputcsv($file_handle, $header);
    fclose($file_handle);
}

if (!isset($_SESSION['identifiant'])) {// Vérifie si l'utilisateur est connecté
    header("Location: ../../accueil/connexion.php");// Redirige l'utilisateur vers page de connexion si pas connecté
    exit();
}

// Récupère les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];


function lireCommentaires() // Fonction pour lire le contenu du fichier CSV des commentaires
{
    global $csv_file;
    $commentaires = array();
    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $commentaires[] = $data;
        }
        fclose($handle);
    }
    return $commentaires;
}

// Supprimer un commentaire
if (isset($_POST['commentaire_id'])) {
    $commentaire_id = $_POST['commentaire_id'];
    // Vérifie si l'utilisateur est l'auteur du commentaire avant de le supprimer
    $commentaires = lireCommentaires();
    if ($commentaires[$commentaire_id][0] == $_SESSION['nom'] && $commentaires[$commentaire_id][1] == $_SESSION['prenom']) {
        // Supprime le commentaire du tableau des commentaires
        unset($commentaires[$commentaire_id]);

        // Réécrire le fichier CSV avec les commentaires mis à jour
        $file_handle = fopen($csv_file, 'w');
        foreach ($commentaires as $commentaire) {
            fputcsv($file_handle, $commentaire);
        }
        fclose($file_handle);

        // Redirection vers la même page pour actualiser la liste des commentaires
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        
        echo "Vous n'êtes pas autorisé à supprimer ce commentaire.";
    }
}

// Ajout d'un nouveau commentaire
if (isset($_POST['sujet']) && isset($_POST['commentaire']) && isset($_POST['date_publication'])) {
    // Données du nouveau commentaire
    $nouveau_commentaire = array($_SESSION['nom'], $_SESSION['prenom'], $_POST['sujet'], $_POST['commentaire'], $_POST['date_publication']);

    // Ajout du nouveau commentaire au fichier CSV
    $file_handle = fopen($csv_file, 'a');
    fputcsv($file_handle, $nouveau_commentaire);
    fclose($file_handle);

    // Redirection vers la même page pour actualiser et afficher le nouveau commentaire
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Appel la fonction
$commentaires = lireCommentaires();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Commentaires</title>
    <link rel="stylesheet" href="./accueil.css">
    <style>
        .navbar {
        background-color: rgba(0, 30, 77, 0.5); /* Couleur avec opacité */
        color: #fff; 
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        backdrop-filter: blur(5px); /* Ajoute un flou à l'arrière de la navbar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ajoute ombre */
        }

        .desktopMenuListItem {
            margin-right: 20px;
            color: #fff;
            text-decoration: none;
        
        }

        .desktopMenuListItem:hover {
            text-decoration: underline; /* GARDE OU PAS */
        }
        body {
            background-color: #001e4d;
        }
        form {
            margin-bottom: 20px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .commentaire {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
    <script src="script.js"></script>
</head>
<body>
<nav class="navbar">
    <img src="./quizzeo-sans-fond.png" alt='logo' class='logo'/>
    <div class='desktopMenu'>
        <a href="page_utilisateur.php" class="desktopMenuListItem">Dashboard</a>
        <a href="profil.php" class="desktopMenuListItem">Profil</a>
        <a href="#" class="desktopMenuListItem">Commentaires</a>
        <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
    </div>
    <p> <span class="pastille"></span> <?php echo $identifiant; ?> connecté </p>
</nav>
<div class= container>
    <h2>Ajouter un Commentaire</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required>

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire" rows="4" required></textarea>

        <label for="date_publication">Date de Publication :</label>
        <input type="date" id="date_publication" name="date_publication" required>

        <input type="submit" value="Ajouter Commentaire">
    </form>


    <h2>Commentaires</h2>
    <div class="commentaires-liste">
        <?php for ($i = 1; $i < count($commentaires); $i++) : ?>
            <div class="commentaire">
                <p><strong>Utilisateur :</strong> <?php echo $commentaires[$i][0] . " " . $commentaires[$i][1]; ?></p>
                <p><strong>Sujet :</strong> <?php echo $commentaires[$i][2]; ?></p>
                <p><strong>Commentaire :</strong> <?php echo $commentaires[$i][3]; ?></p>
                <p><strong>Date de Publication :</strong> <?php echo $commentaires[$i][4]; ?></p>

                <!-- Pour supprimer commentaire-->
                <?php if ($commentaires[$i][0] == $_SESSION['nom'] && $commentaires[$i][1] == $_SESSION['prenom']) : ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="commentaire_id" value="<?php echo $i; ?>">
                        <input  type="submit" value="Supprimer">
                    </form>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

</body>
</html>
