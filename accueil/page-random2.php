<?php


if (!isset($_SESSION['identifiant'])) { // Vérifie si utilisateur connecté
    
    header("Location: connexion.php"); // Redirige utilisateur vers page de connexion si pas connecté
    exit();
}


$id_utilisateur = $_SESSION['id_utilisateur'];// Récupère identifiant de l'utilisateur à partir de la session


if ($_SESSION['role'] !== "Ecole") {// Vérifie si l'utilisateur n'a pas le rôle "Ecole"
    header("Location: connexion.php"); //Redirection car pas autorisation d'accès à la page Ecole
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="./accueil.css">
    <style>
        p{
            font-size: 2.5vh;
            color: green;
            padding-right: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem">Home</a> <!-- a href pour redirection pages -->
            <a href="#" class="desktopMenuListItem">Blog</a>
            <a href="page_utilisateur.php" class="desktopMenuListItem">Compte</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> ecole connecté </p>
    </nav>
    <div>
        <h2> PAGE ECOLE </h2>
    </div>
</body>
</html>