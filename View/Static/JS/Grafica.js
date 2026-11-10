/**
 * grafica.js
 * Dibuja las dos gráficas del dashboard con Chart.js:
 *   - "Usuarios nuevos" por mes (línea)
 *   - "Sugerencias" recibidas por mes (barras)
 *
 * Requisitos (deben estar cargados ANTES de este script):
 *   1. La librería Chart.js (aporta la función global "Chart").
 *   2. Tres variables globales con los datos, definidas por el PHP en
 *      Static/INCLUDE/graficas.php:
 *        - etiquetas          arreglo con los meses (eje horizontal)
 *        - datosUsuarios      arreglo con los usuarios registrados por mes
 *        - datosSugerencias   arreglo con las sugerencias recibidas por mes
 *      Los tres arreglos deben tener la misma longitud.
 *   3. Dos elementos <canvas> en la página, con los ids:
 *        - graficaUsuarios
 *        - graficaSugerencias
 *
 * Secciones del archivo:
 *   1. Opciones generales (compartidas por las dos gráficas)
 *   2. Gráfica de usuarios nuevos (línea)
 *   3. Gráfica de sugerencias (barras)
 *
 * Todo el código va dentro de una función que se ejecuta de inmediato (IIFE)
 * para que las variables internas no choquen con otras del proyecto.
 */
(function () {

    /* 1. OPCIONES GENERALES 
       Se aplican a las dos gráficas:
       - responsive y maintainAspectRatio: la gráfica se adapta al tamaño de su
         contenedor y no conserva una proporción fija.
       - legend: la leyenda está oculta.
       - eje Y: empieza en 0 y muestra solo números enteros. */
    var opciones = {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: false
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    };


    /* 2. GRÁFICA DE USUARIOS NUEVOS (LÍNEA) 
       Se dibuja en el canvas #graficaUsuarios. Solo se crea si el canvas existe en la página.
       Estilo: línea azul (#185FA5) con el área inferior rellena y suavizada(tension 0.3), y puntos de radio 4. */
    var canvasUsuarios = document.getElementById('graficaUsuarios');

    if (canvasUsuarios) {

        new Chart(canvasUsuarios, {
            type: 'line',

            data: {
                labels: etiquetas,

                datasets: [{
                    label: 'Usuarios nuevos',
                    data: datosUsuarios,
                    borderColor: '#185FA5',
                    backgroundColor: 'rgba(24, 95, 165, 0.15)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4
                }]
            },

            options: opciones
        });
    }


    /* 3. GRÁFICA DE SUGERENCIAS (BARRAS)
       Se dibuja en el canvas #graficaSugerencias. Solo se crea si el canvas existe en la página.
       Estilo: barras doradas (#C9A84C) con esquinas redondeadas (radio 8). */
    var canvasSugerencias = document.getElementById('graficaSugerencias');

    if (canvasSugerencias) {

        new Chart(canvasSugerencias, {
            type: 'bar',

            data: {
                labels: etiquetas,

                datasets: [{
                    label: 'Sugerencias',
                    data: datosSugerencias,
                    backgroundColor: '#C9A84C',
                    borderRadius: 8
                }]
            },

            options: opciones
        });
    }

})();