<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupérez l'identifiant de l'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Acceuil</title>
    <link rel="stylesheet" href="./accueil.css">
</head>
<body>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem">Home</a> <!-- a href pour redirection pages -->
            <a href="#" class="desktopMenuListItem">Blog</a>
            <a href="inscription.php" class="desktopMenuListItem">Inscription</a>
            <a href="connexion.php" class="desktopMenuListItem">Connexion</a>
        </div>
    </nav>
</body>
</html>