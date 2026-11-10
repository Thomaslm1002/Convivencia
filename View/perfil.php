<?php
/**
 * perfil.php
 * Página "Mi perfil" de ManualitOnline. Muestra los datos de la persona que
 * tiene la sesión iniciada (administrador o usuario) y ofrece dos formularios:
 *   - actualizar nombre y correo
 *   - cambiar la contraseña
 * Ninguno de los dos formularios se procesa aquí: ambos se envían por POST a
 * ../Controler/perfilctrl.php, que guarda los cambios y vuelve a esta página
 * dejando un mensaje en la sesión.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (dependencias, acceso, carga del perfil, mensaje, ayudas)
 *   2. Cabecera del documento (<head>)
 *   3. Contenido
 *      3.1 Encabezado
 *      3.2 Mensaje de resultado
 *      3.3 Identidad (avatar, nombre, correo y rol)
 *      3.4 Formulario de datos personales
 *      3.5 Formulario de cambio de contraseña
 *      3.6 Enlace para volver al inicio
 */

/* 1. LÓGICA PHP */

// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

// Dependencias
// Conexión a la base de datos (clase ConexionBD) y modelo del perfil (clase Perfil).
// __DIR__ hace que la ruta sea relativa a este archivo, no a donde se ejecute.
require_once __DIR__ . '/../Controler/conexionbd.php';
require_once __DIR__ . '/../Model/perfil.php';

// Obtiene la conexión activa a la base de datos.
$conexion = ConexionBD::getConn();

// Control de acceso: debe haber sesión iniciada
// Si faltan el correo o el tipo de cuenta en la sesión, se redirige y se
// detiene la ejecución.
if (empty($_SESSION['correo']) || empty($_SESSION['tipo'])) {
    header('Location: ../index.php');
    exit;
}

// Cargar el perfil
// Busca en la base de datos los datos de la persona usando el correo y el
// tipo de cuenta guardados en la sesión.
$perfil = new Perfil($conexion);
$datos  = $perfil->obtenerPerfil($_SESSION['correo'], $_SESSION['tipo']);

// Si la sesión apunta a una cuenta que ya no existe, se cierra la sesión y se redirige.
if (!$datos) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

// Mensaje de una sola vez (lo deja perfilctrl.php)
// Se lee de la sesión y se borra enseguida, para que aparezca solo una vez.
// Estructura esperada: ['tipo' => 'ok' | otro valor, 'texto' => '...'].
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

// Funciones y datos auxiliares

// Escapa un texto para mostrarlo de forma segura en HTML (evita inyección de código).
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Primera letra del nombre en mayúscula; se usa como avatar.
$inicial = mb_strtoupper(mb_substr($datos['nombre'], 0, 1, 'UTF-8'), 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">

<!-- 2. CABECERA DEL DOCUMENTO
     Codificación, diseño responsive, título de la pestaña, fuente DM Sans
     de Google y la hoja de estilos propia del perfil. -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi perfil | ManualitOnline</title>

  <!-- Fuente -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="Static/CSS/perfil.css">
</head>

<body class="perfil-page">
<div class="perfil-container">

  <!-- 3. CONTENIDO -->

  <!-- 3.1 ENCABEZADO -->
  <header class="perfil-header">
    <center><img class="perfil-logo" src="STATIC/IMG/LogoSF.png" alt="ManualitOnline"></center>
    <span class="perfil-eyebrow">MI CUENTA</span>
    <h1>Mi perfil</h1>
    <p class="perfil-subtitulo">Consulta y actualiza tu información personal.</p>
  </header>

  <!-- 3.2 MENSAJE DE RESULTADO
       Solo aparece si perfilctrl.php dejó un mensaje. La clase "exito" se usa
       cuando el tipo es 'ok' y "error" en cualquier otro caso. -->
  <?php if ($mensaje): ?>
    <div class="perfil-mensaje <?= $mensaje['tipo'] === 'ok' ? 'exito' : 'error' ?>">
      <?= e($mensaje['texto']) ?>
    </div>
  <?php endif; ?>

  <!-- 3.3 IDENTIDAD
       Avatar con la inicial del nombre, nombre completo, correo y rol
       (administrador o usuario, con la primera letra en mayúscula). -->
  <section class="perfil-card perfil-identidad">
    <div class="perfil-avatar"><?= e($inicial) ?></div>
    <div>
      <h2><?= e($datos['nombre']) ?></h2>
      <p><?= e($datos['correo']) ?></p>
      <span class="perfil-rol"><?= e(ucfirst($_SESSION['tipo'])) ?></span>
    </div>
  </section>

  <!-- 3.4 DATOS PERSONALES
       Formulario para cambiar nombre y correo. El campo oculto
       accion="actualizar" le indica a perfilctrl.php qué debe hacer. -->
  <section class="perfil-card">
    <h2>Datos personales</h2>
    <p class="perfil-descripcion">Actualiza tu nombre y correo electrónico.</p>

    <form class="perfil-form" method="POST" action="../Controler/perfilctrl.php">
      <input type="hidden" name="accion" value="actualizar">

      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             value="<?= e($datos['nombre']) ?>" maxlength="100" required>

      <label for="correo">Correo electrónico</label>
      <input type="email" id="correo" name="correo"
             value="<?= e($datos['correo']) ?>" required>

      <button type="submit" class="perfil-btn">Guardar cambios</button>
    </form>
  </section>

  <!-- 3.5 CAMBIO DE CONTRASEÑA
       Formulario con la contraseña actual, la nueva y su confirmación. El
       campo oculto accion="clave" le indica a perfilctrl.php qué debe hacer.
       minlength="8" solo avisa en el navegador; la regla debe validarse
       también en el servidor. autocomplete="off" evita que el navegador
       rellene los campos. -->
  <!-- 3.5 CAMBIO DE CONTRASEÑA -->
  <section class="perfil-card">
    <h2>Cambiar contraseña</h2>
    <p class="perfil-descripcion">Usa una contraseña de al menos 8 caracteres.</p>

    <form class="perfil-form" method="POST" action="../Controler/perfilctrl.php" autocomplete="off">
      <input type="hidden" name="accion" value="clave">

      <label for="clave_actual">Contraseña actual</label>
      <div class="campo-password">
        <input type="password" id="clave_actual" name="clave_actual" required>
        <button
          type="button"
          class="show-password"
          aria-label="Mostrar contraseña actual"
          aria-pressed="false">👁</button>
      </div>

      <label for="clave_nueva">Nueva contraseña</label>
      <div class="campo-password">
        <input type="password" id="clave_nueva" name="clave_nueva" minlength="8" required>
        <button
          type="button"
          class="show-password"
          aria-label="Mostrar nueva contraseña"
          aria-pressed="false">👁</button>
      </div>

      <label for="clave_confirmar">Confirmar nueva contraseña</label>
      <div class="campo-password">
        <input type="password" id="clave_confirmar" name="clave_confirmar" minlength="8" required>
        <button
          type="button"
          class="show-password"
          aria-label="Mostrar confirmación de contraseña"
          aria-pressed="false">👁</button>
      </div>

      <button type="submit" class="perfil-btn">Cambiar contraseña</button>
    </form>
  </section>


  <!-- 3.6 ENLACE PARA VOLVER -->
  <footer class="perfil-footer">
    <a href="index.php">&larr; Volver al inicio</a>
  </footer>

  <script src="Static/JS/mostrar.js"></script>
</div>
</body>
</html>