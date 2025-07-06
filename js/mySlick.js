// Bandera para asegurar que el carrusel se inicializa solo una vez
var slickInitialized = false;

// Cuando se hace clic en el botón de la flecha...
$('#slideBtn').on('click', function () {
    // Si el carrusel ya fue inicializado, no hacemos nada más.
    if (slickInitialized) {
        return;
    }

    // Inicializamos el carrusel por primera vez.
    $('.killersContainer').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1080,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: { slidesToShow: 1, slidesToScroll: 1 }
        },
        {
            breakpoint: 480,
            settings: { slidesToShow: 1, slidesToScroll: 1 }
        }
        ]
    });

    // Marcamos el carrusel como inicializado.
    slickInitialized = true;
});
