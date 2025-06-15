document.addEventListener('DOMContentLoaded', function() {
    const slideBtn = document.getElementById('slideBtn');
    const killersContainer = document.getElementById('killersContainer');
    const mastheadElement = document.querySelector('header.masthead');

    if (slideBtn && killersContainer) {
        slideBtn.addEventListener('click', function() {
            killersContainer.classList.toggle('visible');
            mastheadElement.classList.toggle('show-full');
        });
    } else {
        if (!slideBtn) {
            console.error('Error: El botón con ID "slideBtn" no fue encontrado.');
        }
        if (!killersContainer) {
            console.error('Error: El contenedor con ID "killersContainer" no fue encontrado.');
        }
    }

});
