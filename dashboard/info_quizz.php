<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes des Élèves</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notes des Élèves</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Charger le fichier CSV
                    $csvFile = fopen('quizz.csv', 'r');

                    // Vérifier si le fichier CSV est ouvert avec succès
                    if ($csvFile !== FALSE) {
                        // Lire le fichier ligne par ligne
                        while (($data = fgetcsv($csvFile, 100, ',')) !== FALSE) {
                            // Afficher chaque ligne dans un tableau HTML
                            echo "<tr>";
                            foreach ($data as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                        fclose($csvFile); // Fermer le fichier CSV après utilisation
                    } else {
                        echo "<tr><td colspan='2'>Impossible de charger le fichier CSV</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>