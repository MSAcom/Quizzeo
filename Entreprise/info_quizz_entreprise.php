
<?php
session_start();
 
$id_quizz = $_POST["id"];
 
// Permet de vérifier facilement le rôle de chaque utilisateur
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
</style>
<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo' />
        <div class='desktopMenu'>
            <a href="../quizz/creationquizz/creationquizz.php" class="desktopMenuListItem">Créer un Quizz</a>
            <a href="dashboard_entreprise.php" class="desktopMenuListItem">Dashboard</a>
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
 
        /*-------------Ouvrir le fichier de quizz-----------------*/
        $file_question = fopen("../quizz/creationquizz/questions_quizz.csv", "r");
        $en_tete_question= fgetcsv($file_question);
 
        $col_id_question= array_search('id_question', $en_tete_question);
        $col_nom_question = array_search('question_quizz', $en_tete_question);
 
        /*-------------Ouvrir le fichier de stockage  de tt les reponses-----------------*/
        $file_toutes_reponses = fopen("../quizz/reponsequizz/toutes_reponses.csv", "r");
        $en_tete_toutes_reponses = fgetcsv($file_toutes_reponses);
 
        $col_id_utilisateur_stockage_toutes_reponses = array_search('id_utilisateur', $en_tete_toutes_reponses);
        $col_id_quizz_stockage_toutes_reponses = array_search('id_quizz', $en_tete_toutes_reponses);
        $col_id_reponse_toutes_reponses = array_search('id_reponse', $en_tete_toutes_reponses);
        $col_id_question_toutes_reponses = array_search('id_question', $en_tete_toutes_reponses);
        $col_nom_question_toutes_reponses = array_search('question_quizz', $en_tete_toutes_reponses);
 
        ?>
        <h1>Informations supplémentaires sur ce quizz :</h1>
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
    </script>
        <h2>Réponses au quizz : </h2>
        <table>
            <tr>
                <th>Question</th>
                <th>Réponse</th>
                <th>Nombre de réponse</th>
                <th>Pourcentage</th>
            </tr>
            <?php
                // calcul du nombre total de réponses pour chaque question
                $total_responses = [];
                rewind($file_toutes_reponses);
                while (($data_toutes_reponses = fgetcsv($file_toutes_reponses)) !== FALSE) {
                    if ($data_toutes_reponses[$col_id_quizz_stockage_toutes_reponses] === $id_quizz) {
                        $id_question = $data_toutes_reponses[$col_id_question_toutes_reponses];
                        if (!isset($total_responses[$id_question])) {
                            $total_responses[$id_question] = []; // initialisation d'un tableau pour chaque question
                        }
                        $reponse_id = $data_toutes_reponses[$col_id_reponse_toutes_reponses];
                        if (!isset($total_responses[$id_question][$reponse_id])) {
                            $total_responses[$id_question][$reponse_id] = 1;
                        } else {
                            $total_responses[$id_question][$reponse_id]++;
                        }
                    }
                }
           
                
                foreach ($total_responses as $id_question => $reponses) {
                    echo "<tr>";
                    $nom_question = ""; 
               
                    // Récupération du nom de la question
                    $file_questions = fopen("../quizz/creationquizz/questions_quizz.csv", "r");
                    $en_tete_questions = fgetcsv($file_questions);
                    $col_id_question = array_search('id_question', $en_tete_questions);
                    $col_nom_question = array_search('question_quizz', $en_tete_questions);
                    while (($data_questions = fgetcsv($file_questions)) !== FALSE) {
                        if ($data_questions[$col_id_question] === $id_question) {
                            $nom_question = $data_questions[$col_nom_question];
                            break;
                        }
                    }
                    fclose($file_questions);
    
 
    // calcul du nombre total de réponses pour cette question
    $total_reponses_question = array_sum($reponses);
 
    // afficher des réponses et des pourcentages
    foreach ($reponses as $reponse_id => $nombre_reponses) {
        // recuperer le nom de la reponse
        $file_reponses = fopen("../quizz/creationquizz/reponses_quizz.csv", "r");
        $en_tete_reponses = fgetcsv($file_reponses);
        $col_id_reponse = array_search('id_reponse', $en_tete_reponses);
        $col_reponse = array_search('reponse_quizz', $en_tete_reponses);
        while (($data_reponses = fgetcsv($file_reponses)) !== FALSE) {
            if ($data_reponses[$col_id_reponse] === $reponse_id) {
                $reponse_quizz = $data_reponses[$col_reponse];
                break;
            }
        }
        fclose($file_reponses);
 
        // Calcul du pourcentage
        $pourcentage = ($nombre_reponses / $total_reponses_question) * 100;
        $pourcentageArrondi = round($pourcentage, 2); // arrondir le pourcentage à deux chiffres apres la virgule
        echo "<td>$nom_question</td>"; // Affichage de la question
        
        echo "<td>$reponse_quizz </td>"; // reponse
        echo "<td>$nombre_reponses</td>"; // nombre de reponce pour cette reponse
        echo "<td>$pourcentageArrondi%</td>"; // pourcentage
        echo "</tr>"; 
    }
   
}?>
</div>
</body>
 
</html>
