<?php
session_start();

if (!isset($_SESSION['identifiant'])) {// verifier si l'utilisateur est connecté
    header("Location: ../../accueil/connexion.php");    // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}

if (!isset($_POST['id'])) {// verifier si l'ID du quizz est passé en tant que paramètre POST
    header("Location: ./dashboard.php");    // rediriger l'utilisateur vers une page d'erreur ou une autre page appropriée s'il n'a pas fourni d'ID de quizz

    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];

$id_quizz = $_POST['id'];
$nom_quizz = $_POST['nom'];
$description = $_POST['description'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Reprendre le quizz</title>

</head>
<body>
<nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="../creationquizz/creationquizz.php" class="desktopMenuListItem">Créer un quizz</a>
            <a href="./pagefavoris.php" class="desktopMenuListItem">Favoris</a>
            <a href="../../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p class="message_connexion"> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
    <h1>Reprendre le quizz : <?php echo $nom_quizz; ?></h1>
    <p>Description : <?php echo $description; ?></p>
    
    <form action="../creationquizz/modification_quizz.php" method="post">
        <input type="hidden" name="id_quizz" value="<?php echo $id_quizz; ?>">
        <button type="submit">Modifier le quizz</button>
    </form>
    </div>
</body>
</html>
