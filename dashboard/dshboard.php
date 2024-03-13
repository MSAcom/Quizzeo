<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quiz Dashboard</title>
<link rel="stylesheet" href="dshboard.css">
</head>
<body>
<div class="dashboard">
    <div class="status">
        <?php
        // Simulate the status of the quiz (en cours d'écriture, lancé or terminé)
        $quizStatus = "en cours d'écriture";

        $currentHour = date("H");
            if ($currentHour >= 8 && $currentHour <= 18) {
        $quizStatus = "Lancé";
        } elseif ($currentHour > 18) {
            $quizStatus = "Terminé";
        }
        ?>
       <h1>Status du quiz : <?php echo $quizStatus; ?></h1>
    </div>
    <div class="responses">
        <?php
        // Simulate the number of responses to the quiz
        $numResponses = 25;
        echo "<p>Nombre de réponses au quiz : $numResponses</p>";
        ?>
    </div>
</div>
<nav class="navbar" >
        <link rel="stylesheet" href="./accueil.css">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem">Home</a> <!-- a href pour redirection pages -->
            <a href="./attractions.php" class="desktopMenuListItem">Attractions</a>
            <a href="./pagefavoris.php" class="desktopMenuListItem">Favoris</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Connexion</a>
        </div>
        <!--<p> <span class="pastille"></span> connecté </p>-->

    </nav>

    <h1>BIENVENUE SUR QUIZZEO <!--<?php echo $identifiant; ?>--> !</h1><!--Personnalisation de la session -->
    
</body>
</html>
