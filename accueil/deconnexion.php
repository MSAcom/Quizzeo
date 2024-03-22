<?php 
session_start(); // Démarre la session

// si l'id de l'utilisateur est défini dans la session
if (isset($_SESSION['id_utilisateur'])) {
    // nous recuperons l'ID de l'utilisateur
    $id_utilisateur = $_SESSION['id_utilisateur'];
    
    // detruit les données enregistrees dans la session
    session_unset();
    session_destroy();

    // modifie le statut de l'utilisateur dans le fichier CSV
    $file_name = 'utilisateurs.csv';
    $lines = file($file_name);
    foreach ($lines as $key => &$line) {// on parcours chaque ligne du tableau
        $data = str_getcsv($line);// on stocke ces données dans un tableau (séparés par virgules) => convertit données string en csv
        if ($data[0] == $id_utilisateur) {//  si l'identifiant du quiz correspond
            
            $data[8] = "False"; //nous modifions le statut de l'utilisateur

            $csv_line = fopen('php://temp', 'r+'); //nous réécrivons la ligne modifiée dans le tableau en utilisant fputcsv()
            fputcsv($csv_line, $data);
            rewind($csv_line); //"rembobine" le pointeur => retourne au début du fichier
            $lines[$key] = fgets($csv_line);//on lit une ligne (à partir du pointeur) et cette ligne est stockée dans le tableau "$lines" sous la clé "$key"
            fclose($csv_line);

            break; 
        }
    }


    file_put_contents($file_name, implode('', $lines));// enregistrer le tableau modifié dans le fichier CSV
}


// Redirection vers la page de connexion 
header('Location: connexion.php'); 
exit(); 
?>