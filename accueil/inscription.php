<?php 
session_start();

//captcha personnalisé 
if(isset($_POST['captcha'])) {  //Si input captcha remplie par utilisateur 
   if($_POST['captcha'] == $_SESSION['captcha']) { //Verification de la valeur du captcha avec l'input de l'utilisateur
      echo "Captcha valide !"; 
   } else {
      echo "Captcha invalide...";
   }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="./accueil.css"> <!-- css -->

</head>
<style> 
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
        margin-top:2%;
       
        width: 70%;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.5); /* Couleur avec opacité */
        color: black; 
        border-radius : 20px;
       
        backdrop-filter: blur(5px); /* Ajoute un flou à l'arrière de la navbar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ajoute ombre */
        padding-bottom: 100px;
    }
    .captchacha {
        width: 400px;
        height: auto;
    }
     </style>
<body>
<nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="home.php" class="desktopMenuListItem active">Home</a><!-- a href pour redirection pages -->
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
            <a href="home.php" class="mobileMenuItem">Home</a><!-- a href pour redirection pages -->
            <a href="blog-page.php" class="mobileMenuItem">Blog</a>
            <a href="inscription.php" class="mobileMenuItem">Inscription</a>
            <a href="connexion.php" class="mobileMenuItem">Connexion</a>
        </div>
    </nav>

    <div class="container">
        <h2>Inscription</h2>
        
        <form action="traitement_inscription.php" method="POST" class="inscription-form">
            <div class="form-group">
                <label for="nom">Nom (obligatoire) :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom (obligatoire):</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="identifiant">Identifiant (obligatoire):</label>
                <input type="text" id="identifiant" name="identifiant" required>
            </div>
            <div class="form-group choix">
                <label>Type d'utilisateur :</label>
                
                <div>
                    <input type="radio" id="ecole" name="role" value="Ecole" required> <!--Le type radio pour sélectionner une option parmi d'autres -->
                    <label for="ecole">École</label>
                </div>
                <div>
                    <input type="radio" id="entreprise" name="role" value="Entreprise"required>
                    <label for="entreprise">Entreprise</label>
                </div>
                <div>
                    <input type="radio" id="utilisateur" name="role" value="Utilisateur"required>
                    <label for="utilisateur">Utilisateur</label>
                </div>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe (en 6 chiffres seulement):</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" pattern="\d{6}" maxlength="6" required>
            </div>

            <img class="captchacha" src="captcha.php"/> <!--captcha personnalisé-->
            <label for="captcha-reponse">Recopiez le nombre ci-dessus : </label>
            <input type="text" name="captcha" required/> <!--Required exige que l'utilisateur complète le champs -->
            <input type="submit" />
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