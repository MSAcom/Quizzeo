const times = document.querySelectorAll('.time');
 
let seconds = 0;
let interval;
 
function startCountdown() {
    interval = setInterval(updateCountdown, 1000);
}
 
function stopCountdown() {
    clearInterval(interval);
}
 
function resetCountdown() {
    stopCountdown();
    seconds = 0;
    updateCountdown();
}
 
function updateCountdown() {
    seconds++;
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;
 
    times[0].textContent = String(hours).padStart(2, '0');
    times[1].textContent = String(minutes).padStart(2, '0');
    times[2].textContent = String(remainingSeconds).padStart(2, '0');
}
 
startCountdown(); // Démarrer le décompte automatiquement jscript décompte