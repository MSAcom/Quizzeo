<?php
session_start();


if (!isset($_SESSION['identifiant'])) {// Vérifie si l'utilisateur est connecté
    header('Location: connexion.php');
    exit();
}


$file_name = 'utilisateurs.csv';// Récupère les données de l'utilisateur du fichier CSV
$file = fopen($file_name, 'r'); // Ouvre en mode lecture 
$user_data = []; 
while (($line = fgetcsv($file)) !== false) { 
    if ($line[3] === $_SESSION['identifiant']) {
        $user_data = $line;// Stocke dans une variable (tableau)
        break;
    }
}
fclose($file);


if (isset($_POST['submit'])) {// Lorsque envoie le formulaire de modification, stocke les input entrés 
    $nouveau_nom = $_POST['nouveau_nom'];
    $nouveau_prenom = $_POST['nouveau_prenom'];
    $nouveau_email = $_POST['nouveau_email']; 
    $ancien_mot_de_passe = $_POST['ancien_mot_de_passe'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];

   
    if (password_verify($ancien_mot_de_passe, $user_data[5])) { // Vérifie si input ancien mot de passe correspond au mot de passe ds CSV
        // Remplace les valeurs du CSV
        $user_data[1] = $nouveau_nom;
        $user_data[2] = $nouveau_prenom;
        $user_data[6] = $nouveau_email; 

        // Fichier CSV temporaire 
        $file = fopen($file_name, 'r+');
        $temp = [];
        while (($line = fgetcsv($file)) !== false) {
            if ($line[3] === $_SESSION['identifiant']) {
                $line = $user_data;
            }
            $temp[] = $line;
        }
        fclose($file);

        // Réécrit toutes les données du fichier temporaire dans le fichier CSV d'origine
        $file = fopen($file_name, 'w');
        foreach ($temp as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        // Redireciton avec message de succès
        header('Location: profil.php?success=' . urlencode('Modifications enregistrées avec succès'));
        exit();
    } else { 
        $error = 'Ancien mot de passe incorrect';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="./accueil.css">
</head>
<body>
    <nav class="navbar">
        <img src="../quizz/images/quizzeo-sans-fond.png"  alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="../quizz/reponsequizz/historique.php" class="desktopMenuListItem">Dashboard</a> <!-- a href pour redirection pages -->
            <a href="profil.php" class="desktopMenuListItem">Profil</a>
            <a href="commentaires.php" class="desktopMenuListItem">Commentaires</a>
            <a href="deconnexion.php" class="desktopMenuListItem">Deconnexion</a>
        </div>
        <p> <span class="pastille"></span> user connecté </p>
    </nav>
    <div class="container">
    <h2>Profil de <?= $user_data[1] ?> <?= $user_data[2] ?></h2>
    
    
    <?php if (isset($error)) : ?><!-- Affichage message erreur -->
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    
    <?php if (isset($_GET['success'])) : ?><!-- Affichage message succès -->
        <p><?= $_GET['success'] ?></p>
    <?php endif; ?>

    <!-- Formulaire de modification -->
    <form action="profil.php" method="post">
        <label for="nouveau_nom">Nouveau nom :</label>
        <input type="text" id="nouveau_nom" name="nouveau_nom" value="<?= $user_data[1] ?>" required> <!-- Value met par défaut une valeur, qui sera ici, celle déjà présente dans le fichier CSV -->
        <label for="nouveau_prenom">Nouveau prénom :</label>
        <input type="text" id="nouveau_prenom" name="nouveau_prenom" value="<?= $user_data[2] ?>" required>
        <label for="nouveau_email">Nouvel email :</label>
        <input type="email" id="nouveau_email" name="nouveau_email" value="<?= isset($user_data[6]) ? $user_data[6] : '' ?>" required> <!-- L'email n'est pas demandé à l'inscription donc le CSV peut etre vide donc value le sera aussi -->
        <label for="ancien_mot_de_passe">Ancien mot de passe :</label>
        <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" required>
        <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" >
        <input type="submit" name="submit" value="Enregistrer les modifications">
    </form>
    </div>
</body>
</html>