<?php
session_start();

$id_quizz = $_POST["id"];

//Permet de vérifier facilement le role de chaque utilisateur
$csvFile = '../accueil/utilisateurs.csv'; // Chemin fichier CSV
if (($handle = fopen($csvFile, "r")) !== FALSE) {// Ouvrir le fichier CSV en mode lecture seulement
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //Parcours tant qu'il y'a de lignes
        
        $users[$data[3]] = array( // Crée tableau users et grace à l'identifiant de l'utilisateur, va stocker le role de l'utilisateur
            'role' => $data[4]
        );
    }
    fclose($handle);
}


$identifiant = $_SESSION['identifiant'];
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Ecole') {// Vérifie si l'utilisateur a le rôle "Utilisateur"
    // Si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../accueil/connexxion.php"); //redirection
    exit();
}
// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs ayant répondu au quizz</title>
    <link rel="stylesheet" href="../accueil/accueil.css">
    <link rel="stylesheet" href="../Admin/admin.css">
    <link rel="stylesheet" href="ecole.css">
</head>
<style>
    .navbar{
        height:8rem;
    }
    
    p{
        margin-right: 20px;
        color:black;
    }
    @media (max-width: 950px) {
    .logo {
        display: none;
    }
    .desktopMenu{
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .navbar{
        justify-content: space-around;
    }
    }
    form {
    display: flex;
    align-items: baseline;
    justify-content: center;
    flex-direction: row;
}
    input[type="text"] {
    width: 50%;
    margin-right:10px}
</style>
<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo' />
        <div class='desktopMenu'>
            <a href="../quizz/creationquizz/creationquizz.php" class="desktopMenuListItem">Créer un quizz</a>
            <a href="dashboard_ecole.php" class="desktopMenuListItem">Dashboard</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Déconnexion</a>
        </div>
        <p> <span class="pastille"></span> Ecole </p>
    </nav>
    <div class="container">
        <?php
        /*----------Ouvrir le fichier des utilisateurs----------*/
        $file = fopen("../accueil/utilisateurs.csv", "r");
        $en_tete = fgetcsv($file); 

        $col_Nom = array_search('Nom', $en_tete);
        $col_Prénom = array_search('Prenom', $en_tete);
        $col_Identifiant = array_search('Identifiant', $en_tete);
        $col_role = array_search('role', $en_tete);
        $col_actif = array_search('Actif', $en_tete);
        $col_id_utilisateur = array_search('id_utilisateur', $en_tete);

        /*-------------Ouvrir le fichier de stockage-----------------*/
        $file_stockage = fopen("../quizz/reponsequizz/stockage_reponses.csv", "r");
        $en_tete_stockage = fgetcsv($file_stockage); 

        $col_id_utilisateur_stockage = array_search('id_utilisateur', $en_tete_stockage);
        $col_id_quizz_stockage = array_search('id_quizz', $en_tete_stockage);
        $col_score = array_search('score', $en_tete_stockage);
        $col_nom_quizz_stockage = array_search('nom_quizz', $en_tete_stockage);

        ?>
        <h1>Informations suppémentaires sur ce quizz :</h1>
        <h2>transmettre le lien :</h2>
        <form class="formurl" action="vers_lien.php" method="get">
        <label for="url"></label>
        <input class="url" type="text" id="url" name="url" value="<?php echo "http://localhost/Projet_final/Quizzeo/quizz/reponsequizz/pagequizzreponse.php?id_quizz=". $id_quizz?>" readonly>
        <button class="copyButton" type="button">Copier</button>
    </form>

<script>//javascript pour faire un bouton copier
   
    function copyText() { // fonction pour copier le contenu du champ de saisie
        var urlInput = document.getElementById("url");
        urlInput.select();// selectionne le texte à copier
        document.execCommand("copy");// copie le texte dans le presse-papiers
        window.getSelection().removeAllRanges();
        alert("Contenu copié !"); //affiche un message d'alerte prevenant que le contenu est copié
    }

    document.querySelector(".copyButton").addEventListener("click", copyText); 
    //on utilise la fonction créé précédemment, et on l'execute si l'utilisateur clique sur le bouton copier
</script>
<h2>Reponses au quizz : </h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Note</th>
            </tr>
            <?php
            while (($data_stockage = fgetcsv($file_stockage)) !== FALSE) {
                if ($data_stockage[$col_id_quizz_stockage] === $id_quizz) { //si l'identifiant de l'utilisateur correspond au quizz envoyer en post, on affiche les détails de l'utilisateur
                    $id_utilisateur_stockage = $data_stockage[$col_id_utilisateur_stockage];
                    // on cherche l'utilisateur correspondant dans le fichier des utilisateurs
                    fseek($file, 0); // Réinitialiser le pointeur de fichier
                    while (($data_user = fgetcsv($file)) !== FALSE) {
                        if ($data_user[$col_id_utilisateur] === $id_utilisateur_stockage) {
                            
                            ?>
                            <tr>
                                <td><?php echo $data_user[$col_Nom] ?></td> <!-- On affiche les données voulues-->
                                <td><?php echo $data_user[$col_Prénom] ?></td>
                                <td><?php echo $data_stockage[$col_score] ?></td> 
                            </tr>
                            <?php
                            break; //une fois l'utilisateur trouvé, on sort de la boucle
                        }
                    }
                }
            }
            ?>
        </table>
        <?php
        fclose($file);
        fclose($file_stockage);
        ?>
    </div>
</body>

</html>