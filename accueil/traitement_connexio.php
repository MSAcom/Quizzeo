<?php

require_once 'autoload.php'; // pour pouvoir utiliser la bibliothèque reCaptcha google

session_start();


if (isset($_POST['submitpost'])) { // Vérifie si l'utilisateur a cliqué sur le bouton "Valider"

    
    $recaptcha = new \ReCaptcha\ReCaptcha('6LfgB5gpAAAAAAxITeMf7TDd9fJdk3ChLadrgA8G');// Crée un nouveau ReCaptcha avec clé secrète

    $gRecaptchaResponse = $_POST['g-recaptcha-response']; //Stocke la réponse de l'utilisateur au reCaptcha dans une variable

    $resp = $recaptcha->setExpectedHostname('localhost') 
        ->verify($gRecaptchaResponse); //Verifie la réponse de l'utilisateur et rend une réponse stocké dans $resp


    if ($resp->isSuccess()) { // Si la réponse est bonne
        if (isset($_POST['identifiant']) && isset($_POST['mot_de_passe'])) { // Si les champs identifiant et mdp sont bien remplies 
            $file_name = 'utilisateurs.csv'; //chemin fichier CSV
            $file = fopen($file_name, 'r'); // mode lecture 

            if ($file) { //Si ouvre bien le fichier CSV
                while (($line = fgetcsv($file)) !== false) { // Lire fichier jusqu'à plus de ligne
                    if ($line[3] === $_POST['identifiant']) { // Verifie l'identifiant de la page connexion à celui du CSV enregistré lors de l'sincription
                        if (password_verify($_POST['mot_de_passe'], $line[5])) { // Vérifie pareil pour le mdp

                            //récupère les données de l'utilisateur connecté pour sa session
                            $_SESSION['identifiant'] = $_POST['identifiant']; 
                            $_SESSION['id_utilisateur'] = $line[0];
                            $_SESSION['role'] = $line[4];
                            $_SESSION['nom'] = $line[1]; 
                            $_SESSION['prenom'] = $line[2]; 

                            fclose($file); 

                            //redirection lors de la connexion en fonction du role de l'utilisateur
                            $message = "Vous êtes connecté"; 
                            if ($_SESSION['role'] === "Utilisateur") {
                                header('Location: page_utilisateur.php?message=' . urlencode($message)); // Ajout la variable $message dans l'URL pour debug
                            }
                            if ($_SESSION['role'] === "Entreprise") {
                                header('Location: page-random.php?message=' . urlencode($message));
                            }
                            if ($_SESSION['role'] === "Ecole") {
                                header('Location: page-random2.php?message=' . urlencode($message));
                            }
                            if ($_SESSION['role'] === "Admin") {
                                header('Location: page-admin.php?message=' . urlencode($message));
                            }
                            exit();
                            
                        } else {
                            $error = "Mot de passe ou identifiant incorrect";
                            header('Location: connexion.php?error=' . urlencode($error)); // Ajout la variable $error dans l'URL pour debug
                        }
                        
                    } else {
                        $error = "Mot de passe ou identifiant incorrect";
                        header('Location: connexion.php?error=' . urlencode($error)); 
                        
                    }
                }
                fclose($file);
            } else {
                $error = "Erreur lors de l'ouverture du fichier.";
            }
        } else { 
            $error = "Veuillez remplir tous les champs.";
        }
    } else { //Si la réponse au reCaptcha est mauvaise: 
        
        $error = "Veuillez cocher le captcha pour prouver que vous n'êtes pas un robot."; // message d'erreur
        header('Location: connexion.php?error=' . urlencode($error)); 
        exit();
    }
}

?>