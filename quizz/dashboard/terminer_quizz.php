<?php
$id_quizz = $_POST["id"];
$statut_quizz = $_POST["statut"];
echo $id_quizz." ".$statut_quizz;

// Chemin du fichier CSV
$csv_file = '../creationquizz/quizz.csv';

// Lire le contenu du fichier CSV dans un tableau
$lines = file($csv_file);

// Parcourir chaque ligne du tableau
foreach ($lines as $key => &$line) {
    // Convertir la ligne en tableau en utilisant la virgule comme séparateur
    $data = str_getcsv($line);

    // Si l'identifiant du quiz correspond
    if ($data[0] == $id_quizz) {
        // Modifier le statut du quiz
        $data[5] = "Terminé"; // Assurez-vous que 5 est l'index de la colonne du statut dans votre fichier CSV

        // Réécrire la ligne modifiée dans le tableau
        $lines[$key] = implode(',', $data);
        header("Location: ./dashboard.php");
        break; // Sortir de la boucle après avoir trouvé le quiz
    }
}

// Enregistrer le tableau modifié dans le fichier CSV
file_put_contents($csv_file, implode('', $lines));

?>
