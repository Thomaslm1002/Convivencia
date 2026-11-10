/* Permite mostrar y ocultar cada contraseña de forma independiente */

// Selecciona todos los botones que controlan la visibilidad de las contraseñas
document.querySelectorAll('.show-password').forEach(function (boton) {

    // Detecta cuando el usuario hace clic en un botón de visibilidad
    boton.addEventListener('click', function () {

        // Obtiene el contenedor y el campo de contraseña correspondiente al botón
        const contenedor = boton.closest('.campo-password');
        const campo = contenedor.querySelector('input');

        // Determina si la contraseña debe mostrarse u ocultarse
        const mostrar = campo.type === 'password';

        // Cambia el tipo del campo para mostrar u ocultar su contenido
        campo.type = mostrar ? 'text' : 'password';

        // Actualiza el icono y el estado accesible del botón
        boton.textContent = mostrar ? '🙈' : '👁';
        boton.setAttribute('aria-pressed', String(mostrar));
        boton.setAttribute(
            'aria-label',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );
    });
});
