
const loader = document.querySelector('.loader'); //la div loader de la page home


loader.addEventListener('transitionend', () => {// Ecouteur d'evenement pour detecter la fin de l'animation 
    
    loader.classList.add('hidden');// Ajout de la classe hidden après la fin de l'animation
});


loader.classList.add('fondu-out');// Ajout de la classe fondu-out pour démarrer l'animation de transition