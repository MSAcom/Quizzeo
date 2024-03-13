<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un nouveau quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Vérifier le rôle de l'utilisateur ici
    $role = 'admin'; // Exemple de rôle d'administrateur
    
    if ($role === 'admin') {
        echo '<button onclick="window.location.href=\'create_quiz_form.php\'">Créer un nouveau quiz</button>';
    } else {
        echo 'none';
    }
    ?>
</body>
</html>
