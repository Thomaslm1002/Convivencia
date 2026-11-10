<?php
// Obtiene la ruta de la página actual desde la URL.
$rutaUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Obtiene el nombre de la página actual en minúsculas para identificar
// posteriormente cuál enlace del menú debe aparecer como activo.
$paginaActual = strtolower(
    pathinfo(rtrim($rutaUrl, '/'), PATHINFO_FILENAME)
) ?: 'index';
// Verifica que la función claseActiva no haya sido declarada anteriormente.
if (!function_exists('claseActiva')) {
    // Determina si un enlace corresponde a la página actual.
    function claseActiva(string $href): string
    {
        global $paginaActual;
        // Obtiene el nombre del archivo de destino en minúsculas.
        $destino = strtolower(
            pathinfo($href, PATHINFO_FILENAME)
        );
        // Devuelve la clase "active" cuando el enlace corresponde
        // a la página que se está visualizando.
        return $paginaActual === $destino ? 'active' : '';
    }
}
// Define las páginas que se mostrarán en el menú de navegación.
$menu = [
    'index.php'         => 'Inicio',
    'manual.php'        => 'Manual',
    'quienes-somos.php' => 'Quiénes Somos',
    'actividades.php'   => 'Actividades',
    'equipo.php'        => 'Equipo',
    'contacto.php'      => 'Contáctanos'
];
// Comprueba si existe una sesión iniciada mediante el correo del usuario.
$haySesion = !empty($_SESSION['correo']);
// Obtiene el nombre del usuario almacenado en la sesión.
// Si no existe, muestra "Mi perfil".
$nombreUsuario = htmlspecialchars(
    $_SESSION['usuario'] ?? 'Mi perfil',
    ENT_QUOTES,
    'UTF-8'
);
?>
<!-- Encabezado principal de la página -->
<header>
    <!-- Barra de navegación principal -->
    <nav class="navbar" id="navbar">
        <!-- Logo que enlaza con la página de inicio -->
        <a href="index.php"
           class="logo"
           aria-label="COESCON - Inicio">
            <!-- Imagen del logo institucional -->
            <img src="Static/IMG/LogoSF.png"
                 alt="Logo de COESCON">
        </a>
        <!-- Menú de navegación para escritorio -->
        <ul class="nav-links">
            <!-- Genera automáticamente las opciones definidas en $menu -->
            <?php foreach ($menu as $archivo => $texto): ?>
                <li>
                    <!-- Enlace a cada sección del sitio -->
                    <a href="<?php echo $archivo; ?>"
                       class="nav-link <?php echo claseActiva($archivo); ?>">
                        <!-- Nombre de la sección -->
                        <?php echo $texto; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <!-- Comprueba si el usuario tiene una sesión iniciada -->
            <?php if ($haySesion): ?>

                <!-- Muestra el perfil del usuario autenticado -->
                <li>
                    <a href="perfil.php"
                       class="nav-link nav-usuario">

                        <?php echo $nombreUsuario; ?>

                    </a>
                </li>

                <!-- Permite cerrar la sesión actual -->
                <li>
                    <a href="cerrar_sesion.php"
                       class="nav-link">
                        Cerrar Sesión
                    </a>
                </li>
            <?php else: ?>
                <!-- Muestra las opciones para usuarios no autenticados -->
                <li>
                    <a href="registrar.php"
                       class="nav-link <?php echo claseActiva('registrar.php'); ?>">
                        Registro
                    </a>
                </li>
                <li>
                    <a href="iniciar.php"
                       class="nav-link <?php echo claseActiva('iniciar.php'); ?>">
                        Iniciar Sesión
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <!-- Botón utilizado para abrir el menú en dispositivos móviles -->
        <button
            class="hamburger"
            id="hamburger"
            type="button"
            aria-label="Abrir menú"
            aria-expanded="false"
            aria-controls="mobile-menu">
            <!-- Líneas que forman el icono del menú hamburguesa -->
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
    <!-- Menú de navegación para dispositivos móviles -->
    <div class="mobile-menu" id="mobile-menu">
        <!-- Genera las opciones principales del menú móvil -->
        <?php foreach ($menu as $archivo => $texto): ?>
            <a href="<?php echo $archivo; ?>"
               class="<?php echo claseActiva($archivo); ?>">
                <?php echo $texto; ?>
            </a>
        <?php endforeach; ?>
        <!-- Opciones mostradas cuando existe una sesión -->
        <?php if ($haySesion): ?>
            <a href="#"
               class="mobile-usuario">
                Mi perfil
            </a>
            <a href="cerrar_sesion.php">
                Cerrar Sesión
            </a>
        <?php else: ?>
            <!-- Opciones mostradas cuando no existe una sesión -->
            <a href="registrar.php"
               class="<?php echo claseActiva('registrar.php'); ?>">
                Registro
            </a>
            <a href="iniciar.php"
               class="<?php echo claseActiva('iniciar.php'); ?>">
                Iniciar Sesión
            </a>
        <?php endif; ?>
    </div>
</header>

<script>
// Ejecuta el código cuando se carga el documento.
(function () {
    // Obtiene el botón utilizado para abrir y cerrar el menú móvil.
    const boton = document.getElementById('hamburger');
    // Obtiene el menú de navegación móvil.
    const menu = document.getElementById('mobile-menu');
    // Obtiene la barra de navegación principal.
    const navbar = document.getElementById('navbar');
    // Detiene la ejecución si alguno de los elementos necesarios no existe.
    if (!boton || !menu || !navbar) {
        return;
    }
    // Abre o cierra el menú móvil y actualiza sus atributos de accesibilidad.
    function alternarMenu(abrir) {
        // Agrega o elimina la clase "open" del botón.
        boton.classList.toggle('open', abrir);
        // Agrega o elimina la clase "open" del menú.
        menu.classList.toggle('open', abrir);
        // Indica si el menú está abierto o cerrado.
        boton.setAttribute(
            'aria-expanded',
            String(abrir)
        );
        // Actualiza el texto descriptivo del botón.
        boton.setAttribute(
            'aria-label',
            abrir ? 'Cerrar menú' : 'Abrir menú'
        );
    }
    // Abre o cierra el menú cuando se pulsa el botón hamburguesa.
    boton.addEventListener('click', function () {
        // Comprueba si el menú se encuentra actualmente abierto.
        const abierto = menu.classList.contains('open');
        // Cambia el estado del menú.
        alternarMenu(!abierto);
    });
    // Cierra el menú después de seleccionar una de sus opciones.
    menu.querySelectorAll('a').forEach(function (enlace) {
        enlace.addEventListener('click', function () {
            alternarMenu(false);
        });
    });
    // Permite cerrar el menú utilizando la tecla Escape.
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            alternarMenu(false);
        }
    });
    // Cierra el menú móvil cuando la ventana vuelve a un tamaño de escritorio.
    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            alternarMenu(false);
        }
    });
    // Agrega o elimina la clase "scrolled" dependiendo de la posición
    // vertical de desplazamiento de la página.
    window.addEventListener('scroll', function () {

        navbar.classList.toggle(
            'scrolled',
            window
            .scrollY > 10
        );
    });
})();
</script>
