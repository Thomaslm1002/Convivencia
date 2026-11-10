/**
 * manual.js
 * Comportamiento interactivo de la página manual.php:
 *   1. Menú de navegación móvil (botón hamburguesa)
 *   2. Preguntas frecuentes en forma de acordeón
 *
 * Se carga con "defer" y todo el código espera al evento DOMContentLoaded,
 * es decir, a que el HTML termine de cargarse y los elementos ya existan.
 *
 * Elementos que busca en la página (si no existen, esa parte no se activa):
 *   - .nav-toggle     botón que abre y cierra el menú (lo aporta header.php)
 *   - .main-nav       menú de navegación (lo aporta header.php)
 *   - .faq-item       cada pregunta frecuente de manual.php
 *   - .faq-question   botón con la pregunta, dentro de cada .faq-item
 *
 * El código solo cambia clases CSS ("open") y el atributo aria-expanded;
 * el aspecto de lo abierto y lo cerrado lo define manual.css / styles.css.
 */

document.addEventListener('DOMContentLoaded', () => {

  /*   1. MENÚ DE NAVEGACIÓN MÓVIL 
     - Al pulsar el botón, el menú se abre si estaba cerrado y se cierra si
       estaba abierto. La clase "open" se pone o quita en el botón y en el
       menú a la vez, y aria-expanded avisa a los lectores de pantalla.
     - Al pulsar cualquier enlace del menú, este se cierra, para que no quede
       tapando la página después de navegar. */
  const navToggle = document.querySelector('.nav-toggle');
  const mainNav = document.querySelector('.main-nav');

  // Solo se activa si la página tiene el botón y el menú
  if (navToggle && mainNav) {

    // Abrir / cerrar con el botón
    navToggle.addEventListener('click', () => {
      const isOpen = navToggle.classList.contains('open');
      navToggle.classList.toggle('open', !isOpen);
      navToggle.setAttribute('aria-expanded', String(!isOpen));
      mainNav.classList.toggle('open', !isOpen);
    });

    // Cerrar al elegir un enlace
    mainNav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        navToggle.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        mainNav.classList.remove('open');
      });
    });
  }
  
  /* 2. PREGUNTAS FRECUENTES (ACORDEÓN) 
        Cada .faq-item tiene un botón (.faq-question) y una respuesta. Al pulsar un botón:
       1. Se cierran todas las preguntas (se quita "open" y aria-expanded
          pasa a "false").
       2. Si la pulsada estaba cerrada, se abre (se pone "open" y
          aria-expanded pasa a "true").
          Así solo hay una abierta a la vez, y pulsar la que ya está abierta la
          cierra. En manual.php la primera pregunta ya viene abierta en el HTML. */
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach((item) => {
    const button = item.querySelector('.faq-question');

    // Si un .faq-item no tiene botón, se ignora
    if (!button) return;

    button.addEventListener('click', () => {
      // Se guarda el estado ANTES de cerrar todo
      const isOpen = item.classList.contains('open');

      // Cierra todas las preguntas
      faqItems.forEach((faqItem) => {
        faqItem.classList.remove('open');
        faqItem.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
      });

      // Abre la pulsada, salvo que ya estuviera abierta
      if (!isOpen) {
        item.classList.add('open');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });

});