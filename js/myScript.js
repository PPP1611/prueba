document.addEventListener('DOMContentLoaded', function() {
    const slideBtn = document.getElementById('slideBtn');
    const killersContainer = document.getElementById('killersContainer');
    const mastheadElement = document.querySelector('header.masthead');
    const userContainer = document.getElementById('userContainer'); // Elemento que contiene userIcon y filterIcon

    // Comprobar si los elementos esenciales existen
    if (!slideBtn) {
        console.error('Error: El botón con ID "slideBtn" no fue encontrado.');
        return; // Salir si el botón principal no existe, ya que no se puede adjuntar el listener
    }
    if (!killersContainer) {
        console.error('Error: El contenedor con ID "killersContainer" no fue encontrado.');
        // Se podría decidir continuar si este elemento no es crítico para todas las acciones del botón
    }
    if (!mastheadElement) {
        console.error('Error: El elemento "header.masthead" no fue encontrado.');
    }
    if (!userContainer) {
        console.error('Error: El contenedor con ID "userContainer" no fue encontrado.');
    }

    slideBtn.addEventListener('click', function() {
        // Solo intentar modificar elementos si existen
        if (killersContainer) {
            killersContainer.classList.toggle('visible');
        }
        if (mastheadElement) {
            mastheadElement.classList.toggle('show-full');
        }
        if (userContainer) {
            userContainer.classList.toggle('visible'); // Alternar la visibilidad de userContainer
        }
    });

});
