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
        .navbar {
        background-color: rgba(255, 255, 255, 0.5); /* Couleur avec opacité */
        color: #fff; 
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        backdrop-filter: blur(5px); /* Ajoute un flou à l'arrière de la navbar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ajoute ombre */
        }
    .desktopMenu ul { /* Aligne les éléments de la nav à l'horizontal */
        display:flex;
    }
    a {
        font-family: Arial;
    }
    .logo{
        -webkit-box-reflect: below 0px linear-gradient(to bottom, rgba(0,0,0,0.0), rgba(0,0,0,0.4)); reflection /*effet miroir*/
    }
    .container {
        margin-top:7%;
       
        width: 70%;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.5); /* Couleur avec opacité */
        color: black; 
        border-radius : 20px;
       
        backdrop-filter: blur(5px); /* Ajoute un flou à l'arrière de la navbar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ajoute ombre */
    }
    #connexion-form {
        display:flex;
        align-items:center;
        justify-content:center;
    }
    </style>
</head>
<body>
  
<nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem active">Home</a><!-- a href pour redirection pages -->
            <a href="blog-page.php" class="desktopMenuListItem">Blog</a>
            <a href="inscription.php" class="desktopMenuListItem">Inscription</a>
            <a href="connexion.php" class="desktopMenuListItem">Connexion</a>
        </div>
        <div class="burger-menu" onclick="toggleMobileMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="mobileMenu" id="mobileMenu">
            <a href="#" class="mobileMenuItem">Home</a><!-- a href pour redirection pages -->
            <a href="blog-page.php" class="mobileMenuItem">Blog</a>
            <a href="inscription.php" class="mobileMenuItem">Inscription</a>
            <a href="connexion.php" class="mobileMenuItem">Connexion</a>
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
    <div class="wrap-2"><canvas id="liquid"></canvas></div>
    <script src="gooey.js"></script>
    <script src="app.js"></script>
    <script src="burger.js"></script>
    <footer class="ftr">   
    <li class="copyright"> &copy; 2024 Mon blog. All rights reserved.</li>
    </footer>
</body>
</html>
