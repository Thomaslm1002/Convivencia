<?php
/**
 * editar_contacto.php
 * Formulario para editar un contacto (sugerencia) existente.
 * Recibe el id del contacto por la URL (editar_contacto.php?id=5), carga sus
 * datos en el formulario y, al enviarlo, los actualiza en la base de datos.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (dependencias, carga del contacto, actualización)
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
//  Dependencias: modelo (clase Contacto) y controlador (clase Contactoctrl) 
require_once "../Model/contacto.php";
require_once "../Controler/contactoctrl.php";

// Controlador que realiza las consultas y actualizaciones en la base de datos.
$ctrl = new Contactoctrl();

//  Validar el id recibido por la URL 
// Si no llega el parámetro "id", se vuelve al listado de sugerencias.
if (!isset($_GET['id'])) {
    header("Location: sugerencias.php");
    exit();
}

// Convierte el id a entero para evitar valores no numéricos.
$id = (int) $_GET['id'];

// Cargar el contacto 
// Consulta los datos del contacto correspondiente al ID.
$contacto = $ctrl->buscarPorId($id);

// Si no existe un contacto con ese id, se vuelve al listado.
if ($contacto === null) {
    header("Location: sugerencias.php");
    exit();
}

// Procesar la actualización 
// Solo se ejecuta cuando se presionó el botón "Actualizar".
if (isset($_POST['actualizar'])) {

    // Captura los datos enviados desde el formulario (trim quita espacios sobrantes).
    $nombre   = trim($_POST['Nombre']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $asunto   = trim($_POST['asunto']);
    $mensaje  = trim($_POST['mensaje']);

    // Crea el objeto con los datos nuevos, conservando el mismo id.
    $contactoActualizado = new Contacto($id, $nombre, $correo, $telefono, $asunto, $mensaje);
    $ctrl->actualizar($contactoActualizado);

    // Redirige a la página de sugerencias.
    header("Location: sugerencias.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Contacto -- ManualitOnline</title>
  <link rel="stylesheet" href="Static/CSS/dashboard.css">
  <link rel="stylesheet" href="Static/CSS/Editar.css">
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
</head>
<body>

        <div class="navbar">
            <h2>Editar Contacto</h2>
            <div class="user">Administrador</div>
        </div>
  <!--  4. FORMULARIO DE EDICIÓN  -->
  <div class="formulario">
    <h2>Editar Contacto</h2>

    <form method="POST">
      <input type="text" name="Nombre" value="<?php echo htmlspecialchars($contacto->getNombre()); ?>" required>
      <input type="email" name="correo" value="<?php echo htmlspecialchars($contacto->getCorreo()); ?>" required>
      <input type="text" name="telefono" value="<?php echo htmlspecialchars($contacto->getTelefono()); ?>" required>
      <input type="text" name="asunto" value="<?php echo htmlspecialchars($contacto->getAsunto()); ?>" required>
      <br>
      <br>
      <textarea name="mensaje" required><?php echo htmlspecialchars($contacto->getMensaje()); ?></textarea>

      <!-- El atributo name="actualizar" es el que activa el procesamiento en PHP -->
      <button name="actualizar">
        Actualizar Contacto
      </button>
    </form>
  </div>
</body>
</html>