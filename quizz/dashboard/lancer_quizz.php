<?php
session_start();

//Permet de vérifier facilement le role de chaque utilisateur
$csvFile = '../../accueil/utilisateurs.csv'; // Chemin fichier CSV
if (($handle = fopen($csvFile, "r")) !== FALSE) {// Ouvrir le fichier CSV en mode lecture seulement
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //Parcours tant qu'il y'a de lignes
        
        $users[$data[3]] = array( // Crée tableau users et grace à l'identifiant de l'utilisateur, va stocker le role de l'utilisateur
            'role' => $data[4]
        );
    }
    fclose($handle);
}


$identifiant = $_SESSION['identifiant'];
if (isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Ecole' || isset($users[$identifiant]) && $users[$identifiant]['role'] === 'Entreprise' ) {// Vérifie si l'utilisateur a le rôle "Utilisateur"
    // Si oui alors il accède à la page_utilisateur

} else { //sinon: 
    
    header("Location: ../../accueil/connexion.php"); //redirection
    exit();
}

// Récupérer les données de l'utilisateur 
$id_utilisateur = $_SESSION['id_utilisateur'];
$identifiant = $_SESSION['identifiant'];


$id_quizz = $_POST["id"];
$statut_quizz = $_POST["statut"];


$csv_file = '../creationquizz/quizz.csv';


$lines = file($csv_file);// on lit le contenu du fichier CSV dans un tableau


foreach ($lines as $key => &$line) {// on parcours chaque ligne du tableau
    
    $data = str_getcsv($line);// on stocke ces données dans un tableau (séparés par virgules) => convertit données string en csv


    
    if ($data[0] == $id_quizz) {//  si l'identifiant du quiz correspond
        
        $data[5] = "Lancé"; //nous modifions le statut du quiz


       
        $csv_line = fopen('php://temp', 'r+'); //nous réécrivons la ligne modifiée dans le tableau en utilisant fputcsv()
        fputcsv($csv_line, $data);
        rewind($csv_line); //"rembobine" le pointeur => retourne au début du fichier
        $lines[$key] = fgets($csv_line);//on lit une ligne (à partir du pointeur) et cette ligne est stockée dans le tableau "$lines" sous la clé "$key"
        fclose($csv_line);

        if ($users[$identifiant]['role'] == "Ecole"){ //rediriger vers ecole 
            header("Location: ../../Ecole/dashboard_ecole.php");}
    
        if ($users[$identifiant]['role'] == "Entreprise"){ //rediriger vers entreprise
            header("Location: ../../Entreprise/dashboard_entreprise.php");}
           
        break; // Sortir de la boucle après avoir trouvé le quiz
    }
}


file_put_contents($csv_file, implode('', $lines));// Enregistrer le tableau modifié dans le fichier CSV
?>
