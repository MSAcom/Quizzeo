<?php
session_start();


if (!isset($_SESSION['identifiant'])) { // Vérifie si l'utilisateur est connecté
    header("Location: ../accueil/connexion.php"); // Redirige lutilisateur vers page de connexion si pas connecté
    exit();
}

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
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Admin') {// Vérifie si l'utilisateur a le rôle "Admin"
    // Si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../accueil/connexion.php"); //redirection
    exit();
}

// récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes users créés</title>
    <link rel="stylesheet" href="../accueil/accueil.css">
    <link rel="stylesheet" href="admin.css">

</head>

<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo' />
        <div class='desktopMenu'>
            
            <a href="" class="desktopMenuListItem">Utilisateurs</a>
            <a href="admin.php" class="desktopMenuListItem">Quizz</a>
            <a href="../accueil/deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> connecté </p>
    </nav>
    <div class="container">
        
            <?php
            $file = fopen("../accueil/utilisateurs.csv", "r");
            $en_tete = fgetcsv($file); // Ignorer l'en-tête
            // Recherchez les index des colonnes spécifiques
            $col_Nom = array_search('Nom', $en_tete);
            $col_Prénom = array_search('Prenom', $en_tete);
            $col_Identifiant = array_search('Identifiant', $en_tete);
            $col_role = array_search('role', $en_tete);
            $col_actif = array_search('Actif', $en_tete);
            $col_id_utilisateur = array_search('id_utilisateur', $en_tete);
            $col_Paramètres = array_search('Paramètres', $en_tete);
            $col_connexion = array_search('connecte', $en_tete);
            ?>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Identifiant</th>
                    <th>Role</th>
                    <th>Connecté</th>
                    <th>Actif</th>
                    <th>Paramètres</th>
                </tr>
                <?php
                while (($data = fgetcsv($file)) !== FALSE) {
                    if (!($data[$col_id_utilisateur] === $id_utilisateur)){
                ?> 
                    <tr>
                        <td><?php echo $data[$col_Nom] ?></td>
                        <td><?php echo $data[$col_Prénom] ?></td>
                        <td><?php echo $data[$col_Identifiant] ?></td>
                        <td><?php echo $data[$col_role] ?></td>
                        <td><?php if ( $data[$col_connexion] === "True"){echo "Connecté";} else {echo "Déconnecté";}?> </td> <!--pour voir si l'utilisateur est connecté-->
                        <td><?php if ( $data[$col_actif] === "True"){echo "Actif";} else {echo "Désactivé";}?> </td><!--pour voir si l'utilisateur est désactivé ou pas-->
                        <td>
                            <?php if ($data[$col_actif] === "False") { ?>
                                <form action="activation_user.php" method="post">
                                    <input type="hidden" name="id_utilisateur" value="<?php echo $data[$col_id_utilisateur]; ?>">
                                    <input type="hidden" name="actif" value="<?php echo $data[$col_actif]; ?>">
                                    <button  type="submit" class="activer">Activer</button> <!--pour reactiver un utilisateur-->
                                </form>
                            <?php } ?>
                            <?php if ($data[$col_actif] === "True") { ?>
                                <form action="desactivation_user.php" method="post">
                                    <input type="hidden" name="id_utilisateur" value="<?php echo $data[$col_id_utilisateur]; ?>">
                                    <input type="hidden" name="actif" value="<?php echo $data[$col_actif]; ?>">
                                    <button  type="submit" class="desactiver">Désactiver</button><!--pour desactiver un utilisateur-->
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                }}
                ?>
            </table>
            <?php
            fclose($file);
            ?>
        </div>
    
</body>

</html>
