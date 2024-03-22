<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Mon Site</title>
    <link rel="stylesheet" href="accueil.css">
   


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
    .articles {
        margin-top:7%;
        display: flex;
        width: 70%;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.5); /* Couleur avec opacité */
        color: black; 
        border-radius : 20px;
       
        backdrop-filter: blur(5px); /* Ajoute un flou à l'arrière de la navbar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ajoute ombre */
    }
    .desktopMenuListItem.active {
    color: rgb(110, 178, 255);
}
main {
    height: 100%;
    justify-content : space-between;
}
.articles {
    display: flex;
    
    
}
article {

    border:solid 1px black;
    margin-left : 10px;
    
}
.content{
    color: black;
}



</style>
</head>
<body>
    <header>
        
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="home.php" class="desktopMenuListItem">Home</a><!-- a href pour redirection pages -->
            <a href="#" class="desktopMenuListItem active">Blog</a>
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
            <a href="#" class="mobileMenuItem active">Blog</a>
            <a href="inscription.php" class="mobileMenuItem">Inscription</a>
            <a href="connexion.php" class="mobileMenuItem">Connexion</a>
        </div>
    </nav>
    </header>
    
    <main>
        <div class="bleug">
            <h1>Mon Blog</h1>
        </div>    
        
        <section class="articles container">
            <article>
                <h2>Culture générale</h2>
                <p class="content">Testez votre culture generale, plusieurs type de quizz accesible pour les enfants et les adultes</p>
                <p class="content">C'est à vous de jouer !</p>
                <a href="https://www.laculturegenerale.com/60-tests-de-culture-generale1/">Lire la suite</a>
            </article>
            <article>
                <h2>L'histoire </h2>
                <p class="content">À quoi servent les quizz, quel est l'origine du mot quizz ?</p>
                <p class="content">Découvrons ensemble !</p>
                <a href="https://fr.wikipedia.org/wiki/Quiz">Lire la suite</a>
            </article>
            <article>
                <h2>De la blague </h2>
               
                <p class="content">Vous voulez des blagues des mignons ?</p>
                <p class="content">Regardons ensemble ! <br> <a href="https://www.pinterest.fr/pin/541628292667356167/">Lire la suite</a></p>
            </article>
        </section>
    </main>
    <div class="wrap-2"><canvas id="liquid"></canvas></div>
    <script src="gooey.js"></script>
    <script src="burger.js"></script>
    <footer class="ftr">   
    <li class="copyright"> &copy; 2024 Mon blog. All rights reserved.</li>
    </footer>
    
    
</body>