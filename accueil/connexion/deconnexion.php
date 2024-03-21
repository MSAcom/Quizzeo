<?php
session_start(); // Démarre la session

// Détruit toutes les données enregistrées dans la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion 
header('Location: connexion.php'); 
exit(); 
?>