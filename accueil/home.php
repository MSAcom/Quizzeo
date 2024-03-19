<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Acceuil</title>
    <link rel="stylesheet"  type="text/css" href="./accueil.css">

</head>
<body>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem">Home</a> <!-- a href pour redirection pages -->
            <a href="./attractions.php" class="desktopMenuListItem">Attractions</a>
            <a href="./pagefavoris.php" class="desktopMenuListItem">Favoris</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Connexion</a>
        </div>
        <!--<p> <span class="pastille"></span> connecté </p>-->

    </nav>
    <div class="patterns">
        <svg width="100%" height="100%">
            <defs>
                <pattern id="polka-dots" x="0" y="0"  width="100" height="100"
                    patternUnits="userSpaceOnUse">
                </pattern>  
            </defs>
     
            <text x="50%" y="50%"  text-anchor="middle">
                Bienvenue
            </text>
        </svg>
    </div>
</body>
</html>