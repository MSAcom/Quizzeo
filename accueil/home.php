<?php
session_start();


if (!isset($_SESSION['identifiant'])) { // Vérifie si utilisateur est connecté
    
    header("Location: connexion.php"); // Redirige utilisateur vers page de connexion si nest pas connecté
    exit();
}

// Récupère identifiant d'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Acceuil</title>
    <link rel="stylesheet" href="./accueil.css"> <!--css-->
</head>
<body>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem">Home</a> <!-- a href pour redirection pages -->
            <a href="blog-page.php" class="desktopMenuListItem">Blog</a>
            <a href="inscription.php" class="desktopMenuListItem">Inscription</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
    </nav>
</body>
</html>