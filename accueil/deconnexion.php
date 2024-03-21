<?php 
session_start(); // Démarre la session

// Vérifie si l'id de l'utilisateur est défini dans la session
if (isset($_SESSION['id_utilisateur'])) {
    // Récupère l'ID de l'utilisateur
    $id_utilisateur = $_SESSION['id_utilisateur'];
    
    // Détruit toutes les données enregistrées dans la session
    session_unset();

    // Détruit la session
    session_destroy();

    // Modifie le statut de l'utilisateur dans le fichier CSV
    $file_name = 'utilisateurs.csv';
    $lines = file($file_name); // Lit le contenu du fichier CSV dans un tableau
    foreach ($lines as $key => &$line) {// on parcours chaque ligne du tablea 
        $data = str_getcsv($line);// on stocke ces données dans un tableau (séparés par virgules) => convertit données string en csv
        if ($data[0] == $id_utilisateur) {//  si l'identifiant du quiz correspond
            
            $data[8] = "False"; //nous modifions le statut du quiz

            $csv_line = fopen('php://temp', 'r+'); //nous réécrivons la ligne modifiée dans le tableau en utilisant fputcsv()
            fputcsv($csv_line, $data);
            rewind($csv_line); //"rembobine" le pointeur => retourne au début du fichier
            $lines[$key] = fgets($csv_line);//on lit une ligne (à partir du pointeur) et cette ligne est stockée dans le tableau "$lines" sous la clé "$key"
            fclose($csv_line);

            break; // Sortir de la boucle après avoir trouvé le quiz
        }
    }


    file_put_contents($file_name, implode('', $lines));// Enregistrer le tableau modifié dans le fichier CSV
}


// Redirection vers la page de connexion 
header('Location: connexion.php'); 
exit(); 
?>