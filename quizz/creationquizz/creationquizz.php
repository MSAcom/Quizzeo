<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Quizz</title>
    <link rel="stylesheet" href="creationquizz.css">
</head>
<body>
    <div class="container">
        <h1>Création de Quizz</h1>
        <form action="enregistrement_quizz.php" method="post" id="question-form">
            <div id="questions-container">
                <div class="question">
                    <label for="nom_quizz">Nom du quizz :</label>
                    <input type="text" id="nom_quizz" name="nom_quizz">
                </div>
                <div class="question">
                    <label for="question1">Question 1 :</label>
                    <input type="text" id="question1" name="questions[]">

                    <div class="reponses">
                        <label for="reponse1_1">Réponse 1 :</label>
                        <input type="text" id="reponse1_1" name="reponses[1][]">
                        <input type="radio" id="reponse1_1_correct" name="correct_responses[1]" value="1">
                        <label for="reponse1_1_correct">Correct</label>
                    </div>
                    <div class="reponses">
                        <label for="reponse1_2">Réponse 2 :</label>
                        <input type="text" id="reponse1_2" name="reponses[1][]">
                        <input type="radio" id="reponse1_2_correct" name="correct_responses[1]" value="2">
                        <label for="reponse1_2_correct">Correct</label>
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

                    <div class="reponses">
                        <label for="reponse${questionCounter}_1">Réponse 1 :</label>
                        <input type="text" id="reponse${questionCounter}_1" name="reponses[${questionCounter}][]">
                        <input type="radio" id="reponse${questionCounter}_1_correct" name="correct_responses[${questionCounter}]" value="1">
                        <label for="reponse${questionCounter}_1_correct">Correct</label>
                    </div>
                    <div class="reponses">
                        <label for="reponse${questionCounter}_2">Réponse 2 :</label>
                        <input type="text" id="reponse${questionCounter}_2" name="reponses[${questionCounter}][]">
                        <input type="radio" id="reponse${questionCounter}_2_correct" name="correct_responses[${questionCounter}]" value="2">
                        <label for="reponse${questionCounter}_2_correct">Correct</label>
                    </div>
                    <!-- Ajoutez des champs pour d'autres réponses si nécessaire -->
                `;

                questionsContainer.appendChild(nouvelleQuestion);
            });
        });
    </script>
</body>
</html>
