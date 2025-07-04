document.addEventListener('DOMContentLoaded', function () {
    const slideBtn = document.getElementById('slideBtn');
    const killersContainer = document.getElementById('killersContainer');
    const mastheadElement = document.querySelector('header.masthead');
    const userContainer = document.getElementById('userContainer'); 

    if (!slideBtn || !killersContainer || !mastheadElement || !userContainer) {
        console.error('Error: Algún elemento esencial no fue encontrado.');
        return;
    }

    slideBtn.addEventListener('click', function() {
        if (killersContainer) {
            killersContainer.classList.toggle('visible');
        }
        if (mastheadElement) {
            mastheadElement.classList.toggle('visible');
        }
        if (userContainer) {
            userContainer.classList.toggle('visible'); 
        } 
    });
});

document.addEventListener('DOMContentLoaded', function () {
// Busca el botón que inicia la animación
const slideButton = document.getElementById('slideBtn');

slideButton.addEventListener('click', function() {
  // Tu código existente para animar el masthead
  document.querySelector('.masthead').classList.add('visible');
  
  // Añade esta línea para habilitar el scroll nuevamente
  document.body.style.overflow = 'auto'; 
});

}

