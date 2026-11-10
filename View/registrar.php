<?php
/**
 * registrar.php
 * Página de registro ("Crear Cuenta") de COESCON / ManualitOnline.
 * Muestra el formulario de registro y, al enviarlo, valida los datos, crea la
 * cuenta y abre la sesión. El tipo de cuenta lo decide el servidor: si el
 * correo está en la tabla "administradores" la cuenta es de administrador;
 * en caso contrario es de usuario.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (configuración, dependencias, validación y registro)
 *   2. Cabecera del documento (<head>)
 *   3. Formulario de registro
 */

/*  1. LÓGICA PHP  */

// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

// Dependencias 
// Modelo y controlador de usuarios (Registrar / Registrarctrl)
require_once "../Model/registrar.php";
require_once "../Controler/registrarctrl.php";
// Modelo y controlador de administradores (Administradoresctrl)
require_once "../Model/administradores.php";
require_once "../Controler/administradoresctrl.php";

// Mensaje de error que se muestra encima del formulario (vacío = no se muestra).
$mensaje = '';

// Procesar el registro: solo cuando la página recibe un POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Captura los datos enviados desde el formulario.
    $nombre         = trim($_POST['nombre']);
    $correo         = trim($_POST['correo']);
    $clave          = $_POST['Clave'];
    $confirmarClave = $_POST['confirmarClave'];

    // Controlador que realiza las consultas y el registro en la base de datos.
    $registrarCtrl = new Registrarctrl();

    // Validación 1: las dos contraseñas deben ser iguales.
    if ($clave !== $confirmarClave) {
        $mensaje = "Las contraseñas no coinciden.";

    // Validación 2: el correo no puede estar ya registrado.
    } elseif ($registrarCtrl->existeCorreo($correo)) {
        $mensaje = "Ese correo ya está registrado.";

    // Datos válidos: se crea la cuenta.
    } else {
        // Si el correo está en la tabla 'administradores', la cuenta es de administrador
        $esAdmin = (new Administradoresctrl())->buscarPorCorreo($correo) !== null;
        $tipoCuenta = $esAdmin ? "administrador" : "usuario";

        // El id es null porque lo genera la base de datos
        $registro = new Registrar(null, $nombre, $correo, $clave, $confirmarClave, $tipoCuenta);
        $idNuevo = $registrarCtrl->insertar($registro);

        // Registro exitoso: insertar() devuelve el id de la cuenta nueva.
        if ($idNuevo > 0) {

            // Guarda los datos del usuario en la sesión (inicia sesión automáticamente).
            $_SESSION['id']         = $idNuevo;
            $_SESSION['usuario']    = $nombre;
            $_SESSION['correo']     = $correo;
            $_SESSION['tipo']       = $tipoCuenta;
            $_SESSION['tipoCuenta'] = $tipoCuenta;

            // Redirige según el tipo de cuenta.
            if ($tipoCuenta == "administrador") {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }

        // Si insertar() no devolvió un id válido, se muestra un error.
        $mensaje = "Error al registrar. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<!-- Define la configuración y los recursos principales del documento -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear cuenta | ManualitOnline</title>

    <!-- Carga los estilos generales, de registro y de inicio de sesión -->
    <link rel="stylesheet" href="Static/CSS/styles.css">
    <link rel="stylesheet" href="Static/CSS/Registrar.css">
    <link rel="stylesheet" href="Static/CSS/iniciar.css">

    <!-- Establece el icono que identifica al sitio web -->
    <link rel="icon" href="Static/IMG/LogoSF.png" type="image/png">
</head>

<!-- Presenta la página de registro con sus estilos correspondientes -->
<body class="auth-page">

    <!-- Contiene el formulario y los elementos de creación de cuenta -->
    <main class="register-container">

        <!-- Permite regresar al inicio al hacer clic en el logo de COESCON -->
        <a href="index.php" class="auth-logo">
            <img
                src="Static/IMG/LogoSF.png"
                alt="Logo de COESCON"
                class="auth-logo-img">
        </a>

        <!-- Muestra el título y la descripción del formulario -->
        <h1>Crear cuenta</h1>

        <p class="register-subtitle">
            Únete a nuestra comunidad educativa
        </p>

        <!-- Muestra los mensajes enviados por el controlador -->
        <?php if (!empty($mensaje)): ?>
            <p class="auth-message" role="alert">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <!-- Envía los datos del registro mediante el método POST -->
        <form id="registerForm" method="POST" action="">

            <!-- Recoge el nombre completo del usuario -->
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Ingresa tu nombre completo"
                    autocomplete="name"
                    required>
            </div>

            <!-- Recoge el correo electrónico del usuario -->
            <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    placeholder="ejemplo@correo.com"
                    autocomplete="email"
                    required>
            </div>

            <!-- Organiza los campos de contraseña y confirmación en una fila -->
            <div class="form-row">

                <!-- Permite introducir la contraseña de la cuenta -->
                <div class="form-group">
                    <label for="Clave">Contraseña</label>

                    <!-- Agrupa el campo de contraseña con su botón de visibilidad -->
                    <div class="campo-password">
                        <input
                            type="password"
                            id="Clave"
                            name="Clave"
                            placeholder="Crea una contraseña"
                            autocomplete="new-password"
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

                <!-- Permite confirmar la contraseña de la cuenta -->
                <div class="form-group">
                    <label for="confirmarClave">Confirmar contraseña</label>

                    <!-- Agrupa la confirmación con su botón de visibilidad -->
                    <div class="campo-password">
                        <input
                            type="password"
                            id="confirmarClave"
                            name="confirmarClave"
                            placeholder="Repite tu contraseña"
                            autocomplete="new-password"
                            required>

                        <!-- Permite mostrar u ocultar la contraseña de confirmación -->
                        <button
                            type="button"
                            class="show-password"
                            aria-label="Mostrar confirmación de contraseña"
                            aria-pressed="false">
                            👁
                        </button>
                    </div>
                </div>
            </div>

            <!-- Envía los datos para crear la cuenta -->
            <button type="submit" class="btn">
                Crear cuenta
            </button>

        </form>

        <!-- Separa visualmente el formulario de las opciones de acceso -->
        <div class="divider">
            <span>¿YA TIENES CUENTA?</span>
        </div>

        <!-- Ofrece un enlace para acceder a una cuenta existente -->
        <p class="login-link">
            ¿Ya estás registrado?
            <a href="Iniciar.php">Inicia sesión aquí</a>
        </p>

        <!-- Permite regresar a la página principal -->
        <a href="index.php" class="back-home">
            ← Volver al inicio
        </a>

    </main>

    <!-- Carga el script que controla la visibilidad de las contraseñas -->
    <script src="Static/JS/mostrar.js"></script>
</body>
</html>

