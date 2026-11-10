/**
 * script.js
 * Script principal del sitio COESCON. Se carga en las páginas públicas
 * (index, quienes-somos, manual, actividades, equipo y contacto).
 *
 * Secciones del archivo:
 *   1. Barra de navegación (efecto al desplazarse, menú móvil y enlace activo)
 *   2. Carrusel de actividades
 *   3. Accesibilidad (panel, contraste, texto grande y tamaño de fuente)
 *   4. Animaciones de aparición ("reveal")
 *
 * Funciones que el HTML llama directamente con onclick:
 *   toggleMenu(), closeMobileMenu()          header.php
 *   moveCarousel(dir)                        actividades.php
 *   toggleA11y(), toggleContrast(btn),
 *   toggleText(btn), changeFontSize(d)       panel de accesibilidad de cada página
 *
 * Cada parte comprueba que los elementos existan antes de usarlos, así que el
 * script no falla en las páginas que no los tienen.
 */


// 1. BARRA DE NAVEGACIÓN (efecto al desplazarse, menú móvil y enlace activo)

// Agrega la clase "scrolled" al #navbar cuando se baja más de 20 px,
// para darle un efecto visual al desplazarse por la página.
window.addEventListener('scroll', () => {
    const nb = document.getElementById('navbar');

    if (nb) {
        nb.classList.toggle('scrolled', window.scrollY > 20);
    }
});

// Abre y cierra el menú móvil (botón #hamburger y menú #mobile-menu).
function toggleMenu() {
    const h = document.getElementById('hamburger');
    const m = document.getElementById('mobile-menu');

    if (h && m) {
        h.classList.toggle('open');
        m.classList.toggle('open');
    }
}

// Cierra el menú móvil.
function closeMobileMenu() {
    const h = document.getElementById('hamburger');
    const m = document.getElementById('mobile-menu');

    if (h) {
        h.classList.remove('open');
    }

    if (m) {
        m.classList.remove('open');
    }
}

// Marca con la clase "active" el enlace del menú que corresponde a la página
// actual, comparando el nombre del archivo de la URL con el de cada enlace.
function highlightActiveNav() {
    const currentPath =
        (window.location.pathname.split('/').pop() || 'index.php').toLowerCase();

    const navLinks = Array.from(
        document.querySelectorAll('.nav-links a, .mobile-menu a')
    );

    navLinks.forEach(link => {
        const href = link.getAttribute('href') || '';

        const linkPath =
            (href.split('/').pop() || '').toLowerCase();

        const isHome =
            currentPath === '' || currentPath === 'index.php';

        const isLinkHome =
            linkPath === '' || linkPath === 'index.php';

        if (
            (isHome && isLinkHome) ||
            (!isHome && linkPath === currentPath)
        ) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

window.addEventListener('DOMContentLoaded', highlightActiveNav);


//   2. CARRUSEL DE ACTIVIDADES (actividades.php)

// Pista del carrusel. Si la página no la tiene, el carrusel no se activa.
const track = document.getElementById('carousel');

if (track) {
    // Arrastrar con el mouse para desplazar el carrusel
    let isDragging = false;
    let startX = 0;
    let scrollStart = 0;

    track.addEventListener('mousedown', e => {
        isDragging = true;
        startX = e.pageX - track.offsetLeft;
        scrollStart = track.scrollLeft;

        track.classList.add('grabbing');
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
        track.classList.remove('grabbing');
    });

    document.addEventListener('mousemove', e => {
        if (!isDragging) return;

        e.preventDefault();

        const x = e.pageX - track.offsetLeft;

        track.scrollLeft = scrollStart - (x - startX);
    });

    // Marca como activo el punto que corresponde a la diapositiva visible
    // (310 px es el ancho aproximado de cada diapositiva).
    track.addEventListener('scroll', () => {
        const dots = document.querySelectorAll('.carousel-dot');

        const idx = Math.round(track.scrollLeft / 310);

        dots.forEach((d, i) => {
            d.classList.toggle('active', i === idx);
        });
    });
}

// Desplaza el carrusel una diapositiva: dir = -1 (atrás) o 1 (adelante).
function moveCarousel(dir) {
    if (!track) return;

    track.scrollBy({
        left: dir * 310,
        behavior: 'smooth'
    });
}


// 3. ACCESIBILIDAD (panel, contraste, texto grande y tamaño de fuente)

// Abre y cierra el panel de accesibilidad y actualiza aria-expanded.
let panelOpen = false;

function toggleA11y() {
    panelOpen = !panelOpen;

    const panel = document.getElementById('a11y-panel');
    const button = document.getElementById('a11y-btn');

    panel?.classList.toggle('open', panelOpen);
    button?.setAttribute('aria-expanded', String(panelOpen));
}

// Activa o desactiva el contraste alto (clase "high-contrast" en <body>).
function toggleContrast(btn) {
    if (!btn) return;

    btn.classList.toggle('on');
    document.body.classList.toggle('high-contrast');
}

// Activa o desactiva el texto más grande (clase "large-text" en <body>).
function toggleText(btn) {
    if (!btn) return;

    btn.classList.toggle('on');
    document.body.classList.toggle('large-text');
}

// Ajusta el tamaño base de la fuente: d = -1 (reducir) o 1 (aumentar).
// Se mantiene entre 12 px y 22 px; el tamaño inicial es 16 px.
let fSize = 16;

function changeFontSize(d) {
    fSize = Math.max(12, Math.min(22, fSize + d));

    document.documentElement.style.fontSize = fSize + 'px';
}


// 4. ANIMACIONES DE APARICIÓN ("reveal")

// Elementos del sitio que aparecen con animación. A cada uno se le agrega la
// clase "reveal" y un retraso corto (0, 75, 150 o 225 ms) para que no
// aparezcan todos a la vez. Los que ya traen "reveal" en el HTML también se
// animan. La animación en sí la define el CSS con "reveal" y "visible".
const elementosAnimados = document.querySelectorAll(`
    .hero-copy,
    .hero-panel,
    .section-head,
    .feature-card,
    .rule-card,
    .info-panel,
    .timeline-step,
    .faq-item,
    .calendar-header,
    .cta-box
`);

elementosAnimados.forEach((elemento, index) => {
    elemento.classList.add('reveal');

    const retraso = (index % 4) * 75;
    elemento.style.setProperty('--reveal-delay', `${retraso}ms`);
});

if (!('IntersectionObserver' in window)) {
    // Navegadores sin IntersectionObserver: se muestra todo de inmediato.
    document.querySelectorAll('.reveal').forEach(elemento => {
        elemento.classList.add('visible');
    });
} else {
    // Navegadores modernos: cada elemento aparece (clase "visible") al
    // entrar en pantalla y deja de observarse.
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.10,
        rootMargin: '0px 0px 30px 0px'
    });

    document.querySelectorAll('.reveal').forEach(elemento => {
        revealObserver.observe(elemento);
    });
}
