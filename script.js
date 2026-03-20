document.addEventListener("DOMContentLoaded", function () {
    
    // 1. INICIALIZAR SWIPER (Unificado)
    const swiper = new Swiper(".header-swiper", {
        loop: true,
        spaceBetween: 0,
        centeredSlides: true,
        speed: 800,
        effect: "slide",
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // 2. LÓGICA DEL MENÚ ADAPTATIVO
    const navSlide = () => {
        const burger = document.querySelector('#burger-menu');
        const nav = document.querySelector('#nav-links'); // Asegúrate de que este ID esté en tu HTML
        const navLinks = document.querySelectorAll('.nav-links li');

        // Verificar que los elementos existan para evitar errores en consola
        if (burger && nav) {
            burger.addEventListener('click', () => {
                // Alternar clase para mostrar/ocultar menú
                nav.classList.toggle('nav-active');

                // Animación de los links de la lista
                navLinks.forEach((link, index) => {
                    if (link.style.animation) {
                        link.style.animation = '';
                    } else {
                        link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
                    }
                });

                // Animación de la hamburguesa (se convierte en X)
                burger.classList.toggle('toggle');
            });
        }
    };

    // Ejecutar la función del menú
    navSlide();
});