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
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Entreprise') {// Vérifie si l'utilisateur a le rôle "Utilisateur"
    // Si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../accueil/connexion.php"); //redirection
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

<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo' />
        <div class='desktopMenu'>
            <a href="dashboard_entreprise.php" class="desktopMenuListItem">Quizz</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Déconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        <?php


        /*-------------Ouvrir le fichier de stockage-----------------*/
        $file_stockage = fopen("../quizz/reponsequizz/stockage_reponses.csv", "r");
        $en_tete_stockage = fgetcsv($file_stockage); 
        $col_id_utilisateur_stockage = array_search('id_utilisateur', $en_tete_stockage);
        $col_id_quizz_stockage = array_search('id_quizz', $en_tete_stockage);
        $col_score = array_search('score', $en_tete_stockage);
        $col_nom_quizz_stockage = array_search('nom_quizz', $en_tete_stockage);

        /*-------------Ouvrir le fichier de stockage  de tt les reponses-----------------*/
        $file_toutes_reponses = fopen("../quizz/reponsequizz/toutes_reponses.csv", "r");
        $en_tete_toutes_reponses = fgetcsv($file_toutes_reponses); 

        $col_id_utilisateur_stockage_toutes_reponses = array_search('id_utilisateur', $en_tete_toutes_reponses);
        $col_id_quizz_stockage_toutes_reponses = array_search('id_quizz', $en_tete_toutes_reponses);
        $col_id_reponse_toutes_reponses = array_search('id_reponse', $en_tete_toutes_reponses);
        $col_id_question_toutes_reponses = array_search('id_question', $en_tete_toutes_reponses);
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
<h2>Réponses au quizz : </h2>
        <table>
            <tr>
                <th>Question</th>
                <th>Réponse</th>
                <th>nombre de réponse</th>
                <th>Pourcentage</th>
            </tr>
            <?php 
            
            // Stockage du nombre total de réponses à chaque question
            $total_responses = [];
            $compteur = 0;
            while (($data_toutes_reponses = fgetcsv($file_toutes_reponses)) !== FALSE) {
                if ($data_toutes_reponses[$col_id_quizz_stockage_toutes_reponses] === $id_quizz) {
                    $question_id = $data_toutes_reponses[$col_id_reponse_toutes_reponses];
                    if (!isset($total_responses[$question_id])) {
                        $total_responses[$question_id] = 1;
                        $compteur ++;
                    } else {
                        $total_responses[$question_id]++;
                        $compteur ++;
                    }
                }

            }
            
            foreach ($total_responses as $question_id => $reponses_choisies) {
            echo "<tr>";
            echo "<td>$question_id</td>";
            echo "<td>$reponses_choisies</td>"; //je veux afficher l'id de la question ici
            echo "<td> $total_responses[$question_id] </td>"; // Nombre de personnes ayant choisi cette réponse
            $pourcentage = ($total_responses[$question_id]/$compteur)*100;
            $pourcentageArrondi = round($pourcentage, 2); // Arrondir à deux décimales
            echo "<td> $pourcentageArrondi%</td>"; // Pourcentage de personnes ayant choisi cette réponse
            echo "</tr>";}
            ?>
        </table>
        <?php
        // Fermeture des fichiers
        fclose($file_stockage);
       // fclose($file_toutes_reponses);
        //fclose($file_reponses);
        ?>
    </div>
</body>

</html>
