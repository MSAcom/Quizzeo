<?php

if (!isset($_SESSION['identifiant'])) { // Vérifie si utilisateur connecté
    
    header("Location: connexion.php"); // Redirige utilisateur vers page de connexion si pas connecté
    exit();
}


$id_utilisateur = $_SESSION['id_utilisateur'];// Récupère identifiant de l'utilisateur à partir de la session


if ($_SESSION['role'] !== "Utilisateur") {// Vérifie si l'utilisateur n'a pas le rôle "Utilisateur"
    header("Location: connexion.php"); //Redirection car pas autorisation d'accès à la page Utilisateur
    exit();
}


// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Utilisateur</title>
    <link rel="stylesheet" href="./accueil.css"> <!--fonctionne 1 fois sur 2-->
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
            <a href="profil.php" class="desktopMenuListItem">Profil</a>
            <a href="commentaires.php" class="desktopMenuListItem">Commentaires</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> user connecté </p>
    </nav>
    <h1>BIENVENUE SUR QUIZZEO <?php echo $_SESSION['nom'] . ' ' . $_SESSION['prenom']; ?> !</h1> <!--Personnalisation de la session -->

</body>
</html>