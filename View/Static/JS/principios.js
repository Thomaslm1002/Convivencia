/**
 * principios.js
 * Botones "Ver más" / "Ocultar" de la sección de principios de manual.php.
 *
 * Los principios 7 a 21 llevan en el HTML la clase "principio-oculto" y no se
 * ven al cargar la página. "Ver más" los va mostrando de 3 en 3 (clase
 * "principio-visible") y "Ocultar" los esconde todos de nuevo.
 *
 * Elementos que usa (los dos botones son obligatorios):
 *   - #btnPrincipios                  botón "Ver más"
 *   - #btnOcultarPrincipios           botón "Ocultar" (empieza oculto)
 *   - #principios .feature-card.principio-oculto   los principios escondidos
 *
 * El aspecto lo define el CSS: "principio-oculto" los esconde y
 * "principio-visible" los muestra (manual.css / styles.css).
 *
 * Secciones del archivo:
 *   1. Elementos y variables de estado
 *   2. Botón "Ver más"
 *   3. Botón "Ocultar"
 *
 * Todo el código espera al evento DOMContentLoaded, es decir, a que el HTML
 * termine de cargarse y los elementos ya existan.
 */

document.addEventListener("DOMContentLoaded", function () {

    /* 1. ELEMENTOS Y VARIABLES DE ESTADO 
       - mostrados: cuántos principios ocultos están visibles ahora (empieza en 0).
       - cantidadPorClick: cuántos se muestran cada vez que se pulsa "Ver más". */
    const btnVerMas = document.getElementById("btnPrincipios");
    const btnOcultar = document.getElementById("btnOcultarPrincipios");

    const principios = document.querySelectorAll(
        "#principios .feature-card.principio-oculto"
    );

    let mostrados = 0;
    const cantidadPorClick = 3;


    /* 2. BOTÓN "VER MÁS" 
       Muestra los siguientes 3 principios (o los que queden, con Math.min para
       no pasarse del total). Después:
       - aparece el botón "Ocultar";
       - si ya están todos visibles, desaparece "Ver más". */
    btnVerMas.addEventListener("click", function () {

        const siguiente = Math.min(
            mostrados + cantidadPorClick,
            principios.length
        );

        for (let i = mostrados; i < siguiente; i++) {
            principios[i].classList.add("principio-visible");
        }

        mostrados = siguiente;

        // Al mostrar los primeros nuevos principios,
        // aparece también el botón Ocultar
        btnOcultar.style.display = "inline-block";

        // Si ya están todos mostrados,
        // desaparece Ver más
        if (mostrados >= principios.length) {
            btnVerMas.style.display = "none";
        }

    });


    /* 3. BOTÓN "OCULTAR" 
       Esconde todos los principios adicionales, reinicia el contador y deja los botones como al cargar la página: "Ver más" visible y "Ocultar" escondido. */
    btnOcultar.addEventListener("click", function () {

        principios.forEach(function (principio) {
            principio.classList.remove("principio-visible");
        });

        mostrados = 0;

        // Volver a mostrar Ver más
        btnVerMas.style.display = "inline-block";

        // Ocultar el botón Ocultar
        btnOcultar.style.display = "none";

    });

});