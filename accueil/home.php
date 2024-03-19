<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="./accueil.css"> <!--css-->
    <link rel="stylesheet" href="./loading.css">
</head>

<style>
    .navbar {
        background: white;
    }
    a {
        font-family: Arial;
    }
    .logo{
        -webkit-box-reflect: below 0px linear-gradient(to bottom, rgba(0,0,0,0.0), rgba(0,0,0,0.4)); reflection /*effet miroir*/
    }
    .container {
        margin-top:4%;
        display: flex;
        width: 70%;
        z-index: 1;
    }

    .left {
        flex: 1; /*prioritaire*/
    }

    .left h1 {
        font-weight: 500;
        font-size: 4rem;
        letter-spacing: -0.14rem;
        line-height: 1;
        margin-bottom: 8rem;
        font-family: fantasy;
    }

    .right {
        display: flex;
        flex: 1; /*prioritaire*/
    }

    .right .item {
        background-position: center top;
        background-size: auto 100%;
        border-radius: 0.5rem;
        flex-grow: 1;
        transition: width 300ms ease;
        width: 33.33%; /* pour que les trois images soient côte à côte */
        display: inline-block; /* afficher en ligne */
        box-sizing: border-box; 
        text-align: center; 
        padding: 20px; 
    }

    .right .item:hover {
        width: 100%;
    }

    .right .item + .item {
        margin-left: 10px;
    }
    .search input[type="text"] {
        width: 200px;
        padding: 10px;
        border: 1px solid #ccc; 
        border-radius: 5px; 
    }
    .search button {
        padding: 10px 20px; 
        background-color: #007bff; 
        color: #fff; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
    }
   
    .search button:hover {
        background-color: #0056b3; 
    }
    .desktopMenuListItem.active {
    color: rgb(110, 178, 255);
}

</style>

<body>
    <div class="loader"> <!--loading page-->
        <svg width="100%" height="100%">
            <defs>
                <pattern id="polka-dots" x="0" y="0"  width="100" height="100" patternUnits="userSpaceOnUse"> <!--effet remplissage-->
                </pattern>  
            </defs>
            <text x="50%" y="50%"  text-anchor="middle"> <!--placement du texte dans la page-->
                Bienvenue
            </text>
        </svg>
    </div>
    </div>
    <nav class="navbar">
        <img src="./quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="#" class="desktopMenuListItem active">Home</a> <!-- a href pour redirection pages -->
            <a href="blog-page.php" class="desktopMenuListItem">Blog</a>
            <a href="inscription.php" class="desktopMenuListItem">Inscription</a>
            <a href="connexion.php" class="desktopMenuListItem">Connexion</a>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="left">
                <h1> 
                    Create.<br/>
                    Test.<br/>
                    Learn.<br/>
                </h1>

                <div class="search">
                    <input type="text" placeholder="Find a quizz">
                    <button> Go </button>
                </div>
            </div>

            <div class="right">
                <div class="item" style="background-image: url('ecole2.jpg')">
                    Ecole 
                </div>
                <div class="item" style="background-image: url('utilisateur.jpeg')">
                    Utilisateur  
                </div>
                <div class="item" style="background-image: url('entreprise.jpeg')">
                    Entreprise  
                </div>
                
            </div>
        </div>
    </main>
    <script src="app.js"></script>
</body>

</html>