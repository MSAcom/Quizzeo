<?php

session_start();

if(isset($_POST['captcha'])) { // Vérifie utilisateur a bien remplie input du captcha 
    if($_POST['captcha'] != $_SESSION['captcha']) { // Si l'input est différent de la bonne réponse
        header('Location: inscription.php?error=' . urlencode("Captcha invalide..."));
        exit();
    }
} else { // Si input vide
    header('Location: inscription.php?error=' . urlencode("Captcha manquant..."));
    exit();
}

// Vérifie que les champs suivants ont bien été remplie
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['identifiant']) && isset($_POST['role']) && isset($_POST['mot_de_passe'])) {
    
    $file_name = 'utilisateurs.csv';// Définit nom du fichier CSV 
 
    $file = fopen($file_name, 'a');//Ouvre fichier en mode écriture mais sans écraser.
 
    if (filesize($file_name) == 0) {//Si le fichier CSV est vide, ajoute ligne des catégories
        fputcsv($file, ['Id_utilisateur', 'Nom', 'Prenom', 'Identifiant', 'role','Mot_de_passe','nouveau_email','Actif', 'connecte']);
    }

    fclose($file);

    
    $file = fopen($file_name, 'r'); // Ouvre en mode lecture seulement


    if ($file) { // Si fichier s'ouvre bien

        $identifiant_existe = false; // Initialise la variable
        while (($line = fgetcsv($file)) !== false) {  // Parcours CSV
            if ($line[3] === $_POST['identifiant']) { // Si l'identifiant rentré correspond à un identifiant du CSV 
                $identifiant_existe = true; // La variable se change en true
                break;
            }
        }
        fclose($file); // Ferme le fichier
        
       
        if ($identifiant_existe) { // Si l'identifiant existe déjà
            header('Location: inscription.php?error=' . urlencode("L'identifiant est déjà pris.")); // Redirection et affiche message d'erreur dans l'Url
            exit();
        } else { // Si l'identifiant n'existe pas

            $id_utilisateur = uniqid(); // Définit un id unique pour chaque nouvelle inscription
            $password_hash = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Utilise la fonction password_hash() pour hasher le mot de passe avant de l'enregistrer
            $actif = "True";
            $connecté = "False";
            $email = "";
            $file = fopen($file_name, 'a'); // Ouvre le fichier en mode écriture pour ajouter les informations de l'utilisateur

            fputcsv($file, [$id_utilisateur, $_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['role'], $password_hash, $email, $actif, $connecté]);

            fclose($file); 

            header('Location: connexion.php?success=' . urlencode("Inscription réussie. Connectez-vous maintenant.")); // Redirection et message debug
            exit();
        }
    } else {
        // Si le fichier ne s'est pas ouvert correctement 
        header('Location: inscription.php?error=' . urlencode("Erreur lors de l'ouverture du fichier."));
        exit();
    }
} else {
    // Si les input d'inscription n'ont pas été tous remplie
    header('Location: inscription.php?error=' . urlencode("Données d'inscription manquantes..."));
    exit();
}

?>