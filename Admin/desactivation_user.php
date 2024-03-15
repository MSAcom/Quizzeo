<?php
$id_utilisateur = $_POST["id_utilisateur"];
$action = $_POST["actif"];
 
 
$csv_file = '../accueil/utilisateurs.csv';
 
 
$lines = file($csv_file);// Lire le contenu du fichier CSV dans un tableau
 
 
foreach ($lines as $key => &$line) {// Parcourir chaque ligne du tableau
   
    $data = str_getcsv($line);// Convertir la ligne en tableau en utilisant la virgule comme séparateur
 
   
    if ($data[0] == $id_utilisateur) {// Si l'identifiant de l'utilisateur correspond
       
        $data[6] = "False"; // Modifier l'action  de l'utilisateur
 
       
        $csv_line = fopen('php://temp', 'r+'); // Réécrire la ligne modifiée dans le tableau 
        fputcsv($csv_line, $data);
        rewind($csv_line);
        $lines[$key] = fgets($csv_line);
        fclose($csv_line);
 
        header("Location: ./listeuser.php");
        break; // Sortir de la boucle après avoir trouvé l'utilisateur
    }
}
 
 
file_put_contents($csv_file, implode('', $lines));// Enregistrer le tableau modifié dans le fichier CSV


