<?php


$score = 0;

// Vérification des réponses
if ($_POST['question1'] === 'Paris') {
    $score++;
}

if ($_POST['question2'] === 'Pacifique') {
    $score++;
}

// Affichage des résultats
echo "<h1>Résultats du quizz</h1>";
echo "<p>Votre score est de $score / 2</p>";

?>
<a href='./essaiquizz.php'> retour</a>