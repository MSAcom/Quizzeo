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

<body>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="home.php" class="desktopMenuListItem">Home</a>
            <a href="blog-page.php" class="desktopMenuListItem">Blog</a>
            <a href="#" class="desktopMenuListItem">Inscription</a>
            <a href="./connexion.php" class="desktopMenuListItem">Connexion</a>
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

            <img src="captcha.php"/> <!--captcha personnalisé-->
            <label for="captcha-reponse">Recopiez le nombre ci-dessus : </label>
            <input type="text" name="captcha" required/> <!--Required exige que l'utilisateur complète le champs -->
            <input type="submit" />
        </form>
    </div>
</body>