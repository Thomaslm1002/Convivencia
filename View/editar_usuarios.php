<?php
/**
 * editar_usuario.php
 * Formulario para editar un usuario registrado.
 * Recibe el id del usuario por la URL (editar_usuario.php?id=5), carga sus
 * datos en el formulario y, al enviarlo, actualiza nombre, correo y tipo de
 * cuenta. La contraseña solo se cambia si se escribe una nueva.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (dependencias, carga del usuario, actualización)
 *   2. Cabecera del documento (<head>)
 *   3. Estilos de la página
 *   4. Formulario de edición
 */

/*  1. LÓGICA PHP  */
// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

//  Control de acceso: solo pueden entrar los administradores 
// Si el usuario no tiene sesión o su tipo no es "administrador", se le
// redirige a la página de inicio de sesión y se detiene la ejecución.
if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header("Location: Iniciar.php");
    exit();
}
//  Control de acceso: solo pueden entrar los administradores 
// Si el usuario no tiene sesión o su tipo no es "administrador", se le
// redirige a la página de inicio de sesión y se detiene la ejecución.
if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header("Location: Iniciar.php");
    exit();
}

//  Dependencias: modelo (clase Registrar) y controlador (clase Registrarctrl) 
require_once "../Model/registrar.php";
require_once "../Controler/registrarctrl.php";

// Controlador que realiza las consultas y actualizaciones en la base de datos.
$ctrl = new Registrarctrl();

// Validar el id recibido por la URL ---
// Si no llega el parámetro "id", se vuelve al listado de usuarios.
if (!isset($_GET['id'])) {
    header("Location: ../usuarios.php");
    exit();
}

// Convierte el id a entero para evitar valores no numéricos.
$id = (int) $_GET['id'];

// Cargar el usuario 
// Consulta la información del usuario correspondiente al ID.
$usuario = $ctrl->buscarPorId($id);

// Si no existe un usuario con ese id, se vuelve al listado.
if ($usuario === null) {
    header("Location: ../usuarios.php");
    exit();
}

// Mensaje de error que se muestra encima del formulario (vacío = no se muestra).
$mensaje = '';

// --- Procesar la actualización ---
// Solo se ejecuta cuando se presionó el botón "Actualizar".
if (isset($_POST['actualizar'])) {

    // Captura los datos enviados desde el formulario.
    $nombre     = trim($_POST['Nombre']);
    $correo     = trim($_POST['correo']);
    $tipo       = $_POST['TipoCuenta']; // 'administrador' o 'usuario', en minúscula
    $claveNueva = $_POST['ClaveNueva'] ?? '';

    // Actualiza nombre, correo y tipo de cuenta (los dos null corresponden a
    // campos del modelo que no se modifican aquí).
    $registro = new Registrar($id, $nombre, $correo, null, null, $tipo);
    $ctrl->actualizar($registro);

    // Solo cambia la clave si se escribió una nueva.
    if ($claveNueva !== '') {
        $ctrl->actualizarClave($id, $claveNueva);
    }

    // Redirige al listado de usuarios.
    header("Location: usuarios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario -- ManualitOnline</title>
  <link rel="stylesheet" href="Static/CSS/editar.css">
  <link rel="stylesheet" href="Static/CSS/dashboard.css">
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
</head>
<body>
          <div class="navbar">
            <h2>Editar Usuario</h2>
            <div class="user">Administrador</div>
        </div>
  <!--  4. FORMULARIO DE EDICIÓN  -->
  <div class="formulario">
    <h2>Editar Usuario</h2>
    <!-- Mensaje de error: solo aparece si $mensaje tiene contenido -->
    <?php if (!empty($mensaje)): ?>
      <p style="color:red;"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>
    <form method="POST">
      <!-- Nombre del usuario -->
      <input type="text" name="Nombre"
             value="<?php echo htmlspecialchars($usuario->getNombre()); ?>" required>
      <!-- Correo del usuario -->
      <input type="email" name="correo"
             value="<?php echo htmlspecialchars($usuario->getCorreo()); ?>" required>
      <!-- Contraseña nueva (opcional): si se deja vacía, no se modifica -->
      <input type="text" name="ClaveNueva"
             placeholder="Dejar en blanco para no cambiar la contraseña">
      <br>
      <br>
      <!-- Tipo de cuenta: la opción actual del usuario queda preseleccionada -->
      <select name="TipoCuenta">
        <option value="administrador"
          <?php if ($usuario->getTipoCuenta() == "administrador") echo "selected"; ?>>
          Administrador
        </option>
        <option value="usuario"
          <?php if ($usuario->getTipoCuenta() == "usuario") echo "selected"; ?>>
          Usuario
        </option>
      </select>
      <!-- El atributo name="actualizar" es el que activa el procesamiento en PHP -->
      <button name="actualizar">
        Actualizar Usuario
      </button>

    </form>
  </div>
</body>
</html>