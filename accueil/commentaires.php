<?php
session_start();
 

if (!isset($_SESSION['identifiant'])) {// Vérifie si l'utilisateur est connecté
    
    header("Location: ../../accueil/connexion.php");// Redirige l'utilisateur vers page de connexion si  pas connecté
    exit();
}

// Récupére les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Commentaires</title>
    <link rel="stylesheet" href="./accueil.css">
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
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="page_utilisateur.php" class="desktopMenuListItem">Dashboard</a> <!-- a href pour redirection pages -->
            <a href="profil.php" class="desktopMenuListItem">Profil</a>
            <a href="#" class="desktopMenuListItem">Commentaires</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> user connecté </p>
    </nav>
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