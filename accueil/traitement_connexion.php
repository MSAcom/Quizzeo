<?php

require_once 'autoload.php'; // Pour pouvoir utiliser la bibliothèque reCaptcha google

session_start();

if (isset($_POST['submitpost'])) { // Vérifie si l'utilisateur a cliqué sur le bouton "Valider"
    $recaptcha = new \ReCaptcha\ReCaptcha('6LfgB5gpAAAAAAxITeMf7TDd9fJdk3ChLadrgA8G');// Crée un nouveau ReCaptcha avec clé secrète
    $gRecaptchaResponse = $_POST['g-recaptcha-response']; //Stocke la réponse de l'utilisateur au reCaptcha dans une variable
    $resp = $recaptcha->setExpectedHostname('localhost')->verify($gRecaptchaResponse); //Verifie la réponse de l'utilisateur et rend une réponse stocké dans $resp

    if ($resp->isSuccess()) { // Si la réponse est bonne
        if (isset($_POST['identifiant']) && isset($_POST['mot_de_passe'])) { // Si les champs identifiant et mdp sont bien remplies 
            $file_name = 'utilisateurs.csv'; // Chemin fichier CSV
            $file = fopen($file_name, 'r'); // mode lecture 

            if ($file) { // Si ouvre bien le fichier CSV
                $userFound = false; // Variable pour indiquer si l'utilisateur a été trouvé

                while (($line = fgetcsv($file)) !== false) { // Parcours le CSV
                    if ($line[3] === $_POST['identifiant'] && password_verify($_POST['mot_de_passe'], $line[5])) { // Verifie l'identifiant et le mot de passe entré dans les input à celui du CSV 
                        $userFound = true; // Si concorde avec une ligne du CSV alors utilisateur trouvé 
                        $_SESSION['identifiant'] = $_POST['identifiant']; 
                        $_SESSION['id_utilisateur'] = $line[0];
                        $_SESSION['role'] = $line[4];
                        $_SESSION['nom'] = $line[1]; 
                        $_SESSION['prenom'] = $line[2];
                        break; // Sortir de la boucle quand utilisateur trouvé du coup
                    }
                }
                fclose($file);

                if ($userFound) { 
                    if ($line[7] === "True") { // Verifie si l'utilisateur est actif
                        
                    $csv_file = 'utilisateurs.csv';
                    $file = fopen($file_name, 'r+');
                    $lines = file($csv_file);// on lit le contenu du fichier CSV dans un tableau
                    foreach ($lines as $key => &$line) {// on parcours chaque ligne du tablea u
                        $data = str_getcsv($line);// on stocke ces données dans un tableau (séparés par virgules) => convertit données string en csv
                        if ($data[0] == $_SESSION['id_utilisateur']) {//  si l'identifiant de l'utilisateur correspond
                            
                            $data[8] = "True"; //inscrire l'utilisateur comme connecte

                            $csv_line = fopen('php://temp', 'r+'); //nous réécrivons la ligne modifiée dans le tableau en utilisant fputcsv()
                            fputcsv($csv_line, $data);
                            rewind($csv_line); //"rembobine" le pointeur => retourne au début du fichier
                            $lines[$key] = fgets($csv_line);//on lit une ligne (à partir du pointeur) et cette ligne est stockée dans le tableau "$lines" sous la clé "$key"
                            fclose($csv_line);

                            break;
                        }
                    }


                    file_put_contents($csv_file, implode('', $lines));// enregistrer le tableau modifié dans le fichier CSV

                        //Redirection en fonction du role de l'utilisateur
                        $message = "Vous êtes connecté"; 
                        if ($_SESSION['role'] === "Utilisateur") {
                            header('Location: ../quizz/reponsequizz/historique.php?message=' . urlencode($message)); // Ajout la variable $message dans l'URL pour debug
                        }
                        if ($_SESSION['role'] === "Entreprise") {
                            header('Location: ../Entreprise/dashboard_entreprise?message=' . urlencode($message));
                        }
                        if ($_SESSION['role'] === "Ecole") {
                            header('Location: ../Ecole/dashboard_ecole.php?message=' . urlencode($message));
                        }
                        if ($_SESSION['role'] === "Admin") {
                            header('Location: ../Admin/listeuser.php?message=' . urlencode($message));
                        }
                        exit();
                    } else {
                        $error = "Utilisateur désactivé";
                    }
                } else { 
                    $error = "Mot de passe ou identifiant incorrecttttt";
                }
            } else {
                $error = "Erreur lors de l'ouverture du fichier.";
            }
        } else { 
            $error = "Veuillez remplir tous les champs.";
        }
    } else { 
        $error = "Veuillez cocher le captcha pour prouver que vous n'êtes pas un robot."; 
    }
    
    // Redirection avec message d'erreur 
    header('Location: connexion.php?error=' . urlencode($error));
    exit();
}

?>
