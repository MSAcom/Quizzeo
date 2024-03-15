<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: ../creationquizz/connexion.php");
    exit();
}

// Vérifiez si l'ID du quizz est passé en tant que paramètre POST
if (!isset($_POST['id'])) {
    // Redirigez l'utilisateur vers une page d'erreur ou une autre page appropriée s'il n'a pas fourni d'ID de quizz
    header("Location: ./dashboard.php");
    exit();
}

// Récupérez l'identifiant de l'utilisateur à partir de la session
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];

// Récupérez l'ID du quizz à partir des paramètres POST
$id_quizz = $_POST['id'];
$nom_quizz = $_POST['nom'];
$description = $_POST['description'];

// Vérifiez si l'utilisateur a le droit d'accéder à ce quizz
// Vous pouvez effectuer des vérifications supplémentaires ici, par exemple vérifier si l'utilisateur est l'auteur du quizz

// Si vous utilisez une base de données, vous pouvez effectuer une requête pour récupérer les détails du quizz
// Remplacez cette section par le code qui récupère les détails du quizz à partir de votre source de données

// Exemple :

/*$quizz_details = [
    'nom' => $_POST["nom"],
    'description' => 'Description du quizz',
    // Ajoutez d'autres détails du quizz ici
];*/

// Affichage de la page HTML avec les détails du quizz et un formulaire pour permettre à l'utilisateur de reprendre l'écriture
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
        <img src="../creationquizz/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="./acceuil.php" class="desktopMenuListItem">Home</a>
            <a href="../creationquizz/creationquizz.php" class="desktopMenuListItem">Créer un quizz</a>
            <a href="./pagefavoris.php" class="desktopMenuListItem">Favoris</a>
            <a href="../creationquizz/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
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