<?php
/**
 * Iniciar.php
 * Página de inicio de sesión de COESCON / ManualitOnline.
 * Muestra el formulario de acceso (correo y contraseña) y, al enviarlo,
 * verifica las credenciales. Si son correctas crea la sesión y redirige:
 * los administradores van a dashboard.php y los demás usuarios a index.php.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (configuración, dependencias, verificación del acceso)
 *   2. Cabecera del documento (<head>)
 *   3. Formulario de inicio de sesión
 */

/*  1. LÓGICA PHP  */

// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();
// Modelo y controlador de usuarios (Registrar / Registrarctrl)
require_once "../Model/registrar.php";
require_once "../Controler/registrarctrl.php";
// Modelo y controlador de administradores (no se usan directamente en este archivo)
require_once "../Model/administradores.php";
require_once "../Controler/administradoresctrl.php";

// Procesar el inicio de sesión: solo cuando la página recibe un POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura las credenciales enviadas desde el formulario.
    $correo = trim($_POST['correo']);
    $clave  = $_POST['Clave'];
    // Verifica el correo y la contraseña; devuelve el usuario o null si no coinciden.
    $registrarCtrl = new Registrarctrl();
    $usuario = $registrarCtrl->verificar($correo, $clave);
    // Credenciales correctas
    if ($usuario !== null) {
        // Genera un nuevo identificador de sesión (evita el robo de sesión por fijación).
        session_regenerate_id(true);
        // Crear sesión: guarda los datos del usuario para usarlos en otras páginas.
        $_SESSION['id']      = $usuario->getId();
        $_SESSION['usuario'] = $usuario->getNombre();
        $_SESSION['correo']  = $usuario->getCorreo();
        $_SESSION['tipo']    = $usuario->getTipoCuenta();
        // Redireccionar según el tipo de cuenta
        if ($usuario->getTipoCuenta() === 'administrador') {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    }
    // Credenciales incorrectas: se muestra el mensaje de error sobre el formulario.
    $mensaje = "Correo o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">

<!-- Define la configuración general y los recursos de la página -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | ManualitOnline</title>

    <!-- Establece el icono de la página y carga las hojas de estilos -->
    <link rel="icon" href="Static/IMG/LogoSF.png" type="image/png">
    <link rel="stylesheet" href="Static/CSS/styles.css">
    <link rel="stylesheet" href="Static/CSS/Registrar.css">
    <link rel="stylesheet" href="Static/CSS/Iniciar.css">

    <!-- Importa las fuentes tipográficas utilizadas en el diseño -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap">
</head>

<!-- Aplica los estilos específicos de la página de inicio de sesión -->
<body class="login-page">

    <!-- Contiene el formulario y los elementos de acceso a la plataforma -->
    <main class="login-container">

        <!-- Permite volver al inicio mediante el logo de COESCON -->
        <a href="index.php" class="auth-logo">
            <img
                src="Static/IMG/LogoSF.png"
                alt="Logo de COESCON"
                class="auth-logo-img">
        </a>

        <!-- Presenta el título principal del formulario -->
        <h1>Bienvenido</h1>

        <!-- Explica brevemente el propósito de la página -->
        <p class="login-subtitle">
            Ingresa a la comunidad educativa de ManualitOnline
        </p>

        <!-- Muestra los mensajes enviados por el controlador -->
        <?php if (!empty($mensaje)): ?>
            <p class="auth-message" role="alert">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <!-- Envía las credenciales mediante el método POST -->
        <form id="loginForm" method="POST" action="Iniciar.php">

            <!-- Recoge el correo electrónico asociado a la cuenta -->
            <div class="form-group">
                <label for="email">Correo electrónico</label>

                <input
                    type="email"
                    id="email"
                    name="correo"
                    placeholder="usuario@correo.com"
                    autocomplete="username"
                    required>
            </div>

            <!-- Recoge la contraseña y permite controlar su visibilidad -->
            <div class="form-group password">
                <label for="password">Contraseña</label>

                <!-- Agrupa el campo de contraseña con su botón de visibilidad -->
                <div class="password-field">
                    <input
                        type="password"
                        id="password"
                        name="Clave"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="current-password"
                        required>

                    <!-- Permite mostrar u ocultar la contraseña introducida -->
                    <button
                        type="button"
                        class="show-password"
                        aria-label="Mostrar contraseña"
                        aria-pressed="false">
                        👁
                    </button>
                </div>
            </div>

            <!-- Envía las credenciales para iniciar sesión -->
            <button type="submit" class="btn">
                Ingresar al portal →
            </button>

        </form>

        <!-- Separa visualmente el formulario de las opciones de registro -->
        <div class="divider">
            <span>¿NO TIENES CUENTA?</span>
        </div>

        <!-- Ofrece un enlace para crear una cuenta nueva -->
        <p class="register-link">
            ¿Eres nuevo en la plataforma?
            <a href="Registrar.php">Crear una cuenta</a>
        </p>

        <!-- Permite regresar a la página principal -->
        <a href="index.php" class="back-home">
            ← Volver al inicio
        </a>

    </main>

    <!-- Controla la visibilidad de la contraseña sin enviarla al servidor -->
    <script>
        // Obtiene el campo de contraseña y su botón de visibilidad
        const passwordInput = document.getElementById('password');
        const toggleButton = document.querySelector('.show-password');

        // Alterna entre mostrar y ocultar la contraseña al hacer clic
        toggleButton.addEventListener('click', function () {
            const mostrar = passwordInput.type === 'password';

            passwordInput.type = mostrar ? 'text' : 'password';
            toggleButton.setAttribute('aria-pressed', String(mostrar));
            toggleButton.setAttribute(
                'aria-label',
                mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );
        });
    </script>
</body>
</html>
