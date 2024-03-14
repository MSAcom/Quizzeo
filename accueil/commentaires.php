<?php
session_start();


if (!isset($_SESSION['identifiant'])) { // Vérifie si l'utilisateur est connecté
    header("Location: connexion.php"); // Redirige lutilisateur vers page de connexion si pas connecté
    exit();
}

//Permet de vérifier facilement le role de chaque utilisateur
$csvFile = 'utilisateurs.csv'; // Chemin fichier CSV
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
    <title>Page de Commentaires</title>
    <style>
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
    </style>
</head>
<body>
    <h2>Ajouter un Commentaire</h2>
    <form action="traitement_commentaire.php" method="post">
        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required>

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire" rows="4" required></textarea>

        <label for="date_publication">Date de Publication :</label>
        <input type="date" id="date_publication" name="date_publication" required>

        <input type="submit" value="Ajouter Commentaire">
    </form>

    <!-- Liste des Commentaires (à afficher à partir de la base de données) -->
    <!-- Chaque commentaire devrait avoir un bouton "Modifier" -->

</body>
</html>