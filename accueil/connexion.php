<?php 
$error = isset($_GET['error']) ? $_GET['error'] : ""; // Récupérez la variable d'erreur depuis l'URL
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="./accueil.css"> <!-- css -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!--API reCaptcha Google -->
    <style>/* css dans html*/
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
  
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'> 
            <a href="home.php" class="desktopMenuListItem">Home</a>
            <a href="blog-page.php" class="desktopMenuListItem">Blog</a>
            <a href="./inscription.php" class="desktopMenuListItem">Inscription</a>
            <a href="#" class="desktopMenuListItem">Connexion</a>
        </div> 
    </nav>

    <div class="container">
        <h2>Connexion</h2>
        <?php if ($error !== "") : ?><!--si erreur est different de vide, donc affiche un message -->
            <p class="error"><?php echo $error; ?></p><!--affiche le message d'erreur-->
        <?php endif; ?>
        <form id="connexion-form" action="traitement_connexion.php" method="POST"> <!--formulaire de connexion-->
            <label for="identifiant">Identifiant :</label>
            <input type="text" id="identifiant" name="identifiant" required> 
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <div class="g-recaptcha" data-sitekey="6LfgB5gpAAAAAOR-I-SpHifOl11vbrpErBujBrXM"></div> <!--recaptcha google-->
            <br/>
            <input type="submit" value="Valider" name="submitpost">
        </form>
    </div>
</body>
</html>
