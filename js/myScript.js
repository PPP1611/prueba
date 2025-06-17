document.addEventListener('DOMContentLoaded', function () {
    const slideBtn = document.getElementById('slideBtn');
    const killersContainer = document.getElementById('killersContainer');
    const masthead = document.querySelector('.masthead');

    if (slideBtn && killersContainer && masthead) {
        slideBtn.addEventListener('click', function () {
            killersContainer.classList.add('visible');
            masthead.classList.add('show-full');
        });
    } else {
        console.error("No se encontró uno de los elementos necesarios.");
    }
});
