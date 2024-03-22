<?php

if(isset($_GET['url'])) {// verifier si une url a ete soumise via le formulaire
    
    $url = $_GET['url'];// on recupere l'url depuis le formulaire
    
    
    header("Location: $url");// rediriger vers l'url entree
    exit(); 
}
?>