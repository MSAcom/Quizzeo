<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupérer l'identifiant de l'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
    
    <link rel="stylesheet" href="../../quizz/dashboard/dashboard.css">
    <link rel="stylesheet" href="quizz.css">
</head>
<body>
<nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="listeuser.php" class="desktopMenuListItem">Utilisateurs</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <div class="logodiv">
            <img class="logo" src="quizzeo.png">
        </div>
        <div class="entete">
        <h1 class="titre">Quizz je suis un clown et myriam est un lapin</h1>
        </div>
        <form action="traitement_quizz.php" method="post">
            <div class="question">
                <p>1. Quelle est la capitale de la France ?</p>
                <label><input type="radio" name="question1" value="Paris"> Paris</label>
                <label><input type="radio" name="question1" value="Londres"> Londres</label>
                <label><input type="radio" name="question1" value="Berlin"> Berlin</label>
            </div>
            <div class="question">
                <p>2. Quel est le plus grand océan du monde ?</p>
                <label><input type="radio" name="question2" value="Atlantique"> Atlantique</label>
                <label><input type="radio" name="question2" value="Pacifique"> Pacifique</label>
                <label><input type="radio" name="question2" value="Indien"> Indien</label>
            </div>
            <input type="submit" value="Soumettre">
        </form>
    </div>
</body>
</html>