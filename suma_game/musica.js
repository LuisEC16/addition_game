const soundIcon = document.getElementById('sound-icon');
const backgroundMusic = document.getElementById('musica');

let isPlaying = true;

window.addEventListener('DOMContentLoaded', () => {
    backgroundMusic.play();
});

soundIcon.addEventListener('click', () => {
    console.log(isPlaying); 
    if (isPlaying) {
        backgroundMusic.pause(); 
        soundIcon.src = 'iconos/corneta-sinsonido.png'; 
        soundIcon.alt = 'Sonido Desactivado';
    } else {
        backgroundMusic.play(); // Reproducir música
        soundIcon.src = 'iconos/corneta-consonido.png'; 
        soundIcon.alt = 'Sonido Activado';
    }
    isPlaying = !isPlaying; 
});

