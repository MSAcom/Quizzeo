<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note</title>
    <link rel="styleheet" href="note.css">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $csvFile = fopen('note.csv', 'a');

                if ($csvFile !== FALSE) {
                    while (($data = fgetcsv($csvFile, 100, ',')) !== FALSE) {

                        echo "<tr>";
                        foreach ($data as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "<tr>";
                    }
                    fclose($csvFile); 
                } else {
                    echo "<tr><td colspan='2'> Impossible de charger le ficher csv</td></tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>