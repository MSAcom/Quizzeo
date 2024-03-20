<?php
// Vérifier si une URL a été soumise via le formulaire
if(isset($_GET['url'])) {
    // Récupérer l'URL depuis le formulaire
    $url = $_GET['url'];
    
    // Rediriger vers l'URL spécifiée
    header("Location: $url");
    exit(); // Assurez-vous de sortir du script après la redirection
}
?>