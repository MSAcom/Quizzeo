<?php
$id_quizz = $_POST["id"];
$statut_quizz = $_POST["statut"];


$csv_file = '../creationquizz/quizz.csv';


$lines = file($csv_file);// Lire le contenu du fichier CSV dans un tableau


foreach ($lines as $key => &$line) {// Parcourir chaque ligne du tableau
    
    $data = str_getcsv($line);// Convertir la ligne en tableau en utilisant la virgule comme séparateur

    
    if ($data[0] == $id_quizz) {// Si l'identifiant du quiz correspond
        
        $data[5] = "Lancé"; // Modifier le statut du quiz

       
        $csv_line = fopen('php://temp', 'r+'); // Réécrire la ligne modifiée dans le tableau en utilisant
        fputcsv($csv_line, $data);
        rewind($csv_line);
        $lines[$key] = fgets($csv_line);
        fclose($csv_line);

        header("Location: ./dashboard.php");
        break; // Sortir de la boucle après avoir trouvé le quiz
    }
}


file_put_contents($csv_file, implode('', $lines));// Enregistrer le tableau modifié dans le fichier CSV
?>
