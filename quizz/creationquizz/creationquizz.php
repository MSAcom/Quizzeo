<?php
session_start();


if (!isset($_SESSION['identifiant'])) {// Vérifier si l'utilisateur est connecté
    header("Location: ../../accueil/connexion.php");// Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];// Récupérer l'identifiant de l'utilisateur à partir de la session
$identifiant = $_SESSION['identifiant'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Quizz</title>
    <link rel="stylesheet" href="creationquizz.css">
</head>
<body>
<nav class="navbar">
        <img src="../images/quizzeo-sans-fond.png" height="50" alt='logo' class='logo'/>
        <div class='desktopMenu'>
            <a href="/Projet_final/Quizzeo/accueil/home.php" class="desktopMenuListItem">Home</a>
            <a href="../dashboard/dashboard.php" class="desktopMenuListItem">Dashboard</a>
            <a href="#" class="desktopMenuListItem">Hebergement</a>
            <a href="/Projet_final/Quizzeo/accueil/deconnexion.php" class="desktopMenuListItem">Deconnection</a>
        </div>
        
</nav>
    <div class="container">
        <h1>Création de Quizz </h1>
        <form action="enregistrement_quizz.php" method="post" id="question-form">
            <div id="questions-container">
            <div class="question">
                <div class="center-container">
                    <label for="nom_quizz">Nom du quizz :</label>
                    <input class="nom_quizz" type="text" id="nom_quizz" name="nom_quizz">
                </div>
                <div class="center-container">
                    <label for="description_quizz">Description :</label>
                    <input class="description_quizz" type="text" id="description_quizz" name="description_quizz">
                </div>
            </div>
                <div class="question">
                    <label for="question1">Question 1 :</label>
                    <input type="text" id="question1" name="questions[]">
                    <label for="points1">points pour cette question :</label>
                    <input type="number" class ="points_question" id="points1" name="points[]">
                    <div class="reponses">
                        <label for="reponse1_1">Réponse 1 :</label>
                        <input type="text" id="reponse1_1" name="reponses[1][]">
                        <label for="reponse1_1_correct">Correct</label>
                        <input type="radio" id="reponse1_1_correct" name="correct_responses[1]" value="1">
                        
                    </div>
                    <div class="reponses">
                        <label for="reponse1_2">Réponse 2 :</label>
                        <input type="text" id="reponse1_2" name="reponses[1][]">

                        <label for="reponse1_2_correct">Correct</label>
                        <input type="radio" id="reponse1_2_correct" name="correct_responses[1]" value="2">
                        
                    </div>

                </div>
                
            </div>
            <button type="button" id="ajouter-question">Ajouter une question</button>
            <input type="submit" value="Enregistrer le Quizz">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var questionCounter = 1;

            document.getElementById('ajouter-question').addEventListener('click', function() {
                questionCounter++;
                

                var questionsContainer = document.getElementById('questions-container');

                var nouvelleQuestion = document.createElement('div');
                nouvelleQuestion.classList.add('question');
                nouvelleQuestion.innerHTML = `
               
                    <label for="question${questionCounter}">Question ${questionCounter}:</label>
                    <input type="text" id="question${questionCounter}" name="questions[]">
                    <label for="points${questionCounter}">points pour cette question :</label>
                    <input type="number"  class ="points_question" id="points${questionCounter}"  name="points[]">
                    <div class="reponses">
                        <label for="reponse${questionCounter}_1">Réponse 1 :</label>
                        <input type="text" id="reponse${questionCounter}_1" name="reponses[${questionCounter}][]">
                      
                        <label for="reponse${questionCounter}_1_correct">Correct</label>
                        <input type="radio" id="reponse${questionCounter}_1_correct" name="correct_responses[${questionCounter}]" value="1">
                    </div>
                    <div class="reponses">
                        <label for="reponse${questionCounter}_2">Réponse 2 :</label>
                        <input type="text" id="reponse${questionCounter}_2" name="reponses[${questionCounter}][]">
                       
                        
                        <label for="reponse${questionCounter}_2_correct">Correct</label>
                        <input type="radio" id="reponse${questionCounter}_2_correct" name="correct_responses[${questionCounter}]" value="2">
                    </div>
                   
                `;

                questionsContainer.appendChild(nouvelleQuestion);
            });
        });
    </script>
</body>
</html>
