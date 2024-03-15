<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pourcentage</title>
    <link rel="stylesheet" href="pourcentage copie.css">
</head>
<body>
    <div class="container">
        <h2>Pourcentage des réponses</h2>
        <ul>
            <?php
                $csvFile = fopen("reponses.csv", "a");

                if ($csvFile !== FALSE) {

                    $answers = fgetcsv($csvFile, 100, ',');

                    $counts = fgetcsv($csvFile, 100, ',');

                    $total_responses = array_sum($counts);

                    foreach ($answers as $key => $answers) {
                        $percentage = ($counts[$key] / $total_responses) * 100;
                        echo "<li><strong>Réponse $answer :</strong> $counts[$key] réponse(s) ($percentage %)</li>";

                    }
                    fclose($csvFile);
                }else {
                    echo"<li> Impossible de charger le fichier CSV</li>";
                }
            ?>

          
        </ul>
    </div>
    
</body>
</html>