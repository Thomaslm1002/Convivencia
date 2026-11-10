<?php
/**
 * contacto.php
 * Página "Contáctanos" del sitio COESCON (Comité Escolar de Convivencia).
 * Muestra los datos de contacto y un formulario para que la comunidad envíe
 * dudas, propuestas o quejas. El mismo archivo procesa el formulario (POST)
 * y lo guarda en la base de datos mediante el modelo y el controlador.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (sesión, dependencias, procesamiento del formulario)
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Contacto (datos de contacto y formulario)
 *   6. Pie de página (footer)
 */

/*  1. LÓGICA PHP  */

// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

// Dependencias: el modelo (clase Contacto) y el controlador (clase Contactoctrl,
// que se encarga de guardar el contacto en la base de datos).
require_once "../Model/contacto.php";
require_once "../Controler/contactoctrl.php";

// Texto que se mostrará al usuario como resultado del envío (éxito o error).
$mensaje = '';

// Procesamiento del formulario: solo cuando la página recibe un POST ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recoge los campos del formulario; trim() elimina espacios al inicio y al final
    // y "?? ''" evita errores si algún campo no llega.
    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $asunto   = trim($_POST['asunto'] ?? '');
    $texto    = trim($_POST['mensaje'] ?? '');

    // Validación: nombre, asunto y mensaje son obligatorios y el correo debe ser válido.
    if ($nombre === '' || $asunto === '' || $texto === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Completa los campos obligatorios con un correo válido.";
    } else {
        // El id es null porque lo genera la base de datos
        $contacto = new Contacto(null, $nombre, $correo, $telefono, $asunto, $texto);

        // Si se guarda correctamente, redirige a la misma página con ?enviado=1.
        // Esto evita que el formulario se reenvíe si el usuario recarga la página.
        if ((new Contactoctrl())->insertar($contacto)) {
            header("Location: contacto.php?enviado=1");
            exit();
        }
        // Si insertar() falla, se muestra un mensaje de error.
        $mensaje = "No se pudo enviar el mensaje. Inténtalo de nuevo.";
    }
}

//  Mensaje de confirmación: se activa tras la redirección con ?enviado=1 
if (isset($_GET['enviado'])) {
    $mensaje = "¡Mensaje enviado! Gracias por contactarnos.";
}

?>
<!DOCTYPE html>
<!-- Página de contacto para dudas, propuestas y asesoría estudiantil. -->
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManualitOnline — Contáctanos</title>

  <!-- Fuentes -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=Pirata+One&display=swap" rel="stylesheet">

  <!-- Estilos e ícono -->
  <link rel="stylesheet" href="Static/CSS/styles.css">
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">

  <!-- Script principal -->
  <script src="static/JS/Script.js" defer></script>
</head>

<body>

  <!--  3. ACCESIBILIDAD  -->
  <button id="a11y-btn" aria-label="Accesibilidad" onclick="toggleA11y()">
    <svg viewBox="0 0 24 24">
      <path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8 5H4l3 8h3l1 7h2l1-7h3z"/>
    </svg>
  </button>

  <div id="a11y-panel">
    <h4>Accesibilidad</h4>

    <div class="a11y-row">
      <span>Alto contraste</span>
      <button class="a11y-toggle" id="toggle-contrast" onclick="toggleContrast(this)"></button>
    </div>

    <div class="a11y-row">
      <span>Texto grande</span>
      <button class="a11y-toggle" id="toggle-text" onclick="toggleText(this)"></button>
    </div>

    <div class="a11y-row">
      <span>Tamaño fuente</span>
      <div class="a11y-size">
        <button onclick="changeFontSize(-1)">A−</button>
        <button onclick="changeFontSize(1)">A+</button>
      </div>
    </div>
  </div>

  <!--  4. MENÚ SUPERIOR  -->
  <?php include("Static/INCLUDE/header.php"); ?>

  <!--  5. CONTACTO  -->
  <section id="contacto">
    <div class="container">

      <!-- Encabezado de la sección -->
      <div class="reveal">
        <center><div class="section-label">Contacto</div></center>
        <center><h2 class="section-title">¿Tienes algo que<br>decir? <em style="font-style:italic;color:var(--blue-600)">Te escuchamos.</em></h2></center>
      </div>

      <div class="contact-grid reveal">

        <!-- Columna izquierda: datos de contacto -->
        <div class="contact-info">
          <h3>Estamos aquí para servir a la comunidad estudiantil</h3>
          <p>COESCON tiene puertas abiertas para toda propuesta, queja, idea o simplemente para quien quiera unirse al equipo. Tu participación es el motor de nuestra gestión.</p>

          <!-- Dirección -->
          <div class="contact-item">
            <div class="icon-wrap">📍</div>
            <div class="details">
              <strong>Oficina Principal</strong>
              <span>Cl. 92 #51a 100, Aranjuez, Medellín, Aranjuez, Medellín, Antioquia</span>
            </div>
          </div>

          <!-- Correo -->
          <div class="contact-item">
            <div class="icon-wrap">📧</div>
            <div class="details">
              <strong>Correo Institucional</strong>
              <span>ie.gilbertoalzate@medellin.gov.co</span>
            </div>
          </div>

          <!-- Teléfono -->
          <div class="contact-item">
            <div class="icon-wrap">📞</div>
            <div class="details">
              <strong>Número</strong>
              <span>322 5444440</span>
            </div>
          </div>

          <!-- Horario -->
          <div class="contact-item">
            <div class="icon-wrap">🕐</div>
            <div class="details">
              <strong>Horario de Atención</strong>
              <span>Lun–Vie, 8:00am – 5:00pm</span>
            </div>
          </div>
        </div>
        <!-- Columna derecha: formulario de contacto. Los campos "name" deben coincidir con las claves de $_POST leídas en la sección 1. -->
        <form action="contacto.php" method="POST">
          <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" required>
          </div>
          <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="correo" required>
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono">
          </div>
          <div class="form-group">
            <label>Asunto</label>
            <input type="text" name="asunto">
          </div>
          <div class="form-group">
            <label>Mensaje</label>
            <textarea name="mensaje" rows="5" required></textarea>
          </div>
          <!-- Botón de envío; sendMessage(this) está definida en Script.js -->
          <button class="form-submit">
            <svg width="26" height="26" fill="white" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
            Enviar mensaje
          </button>
        <!-- Estos tres </div> cierran .contact-grid, .container y un tercero sin apertura dentro de la sección; el </form> queda después de ellos. Se conserva el orden original, pero conviene revisarlo. -->
        </div>
      </div>
    </div>
        </form>
  </section>

  <!-- 6. FOOTER -->
  <footer>
    <div class="footer-grid">

      <div class="footer-brand">
        <div class="logo">COESCON</div>
        <p>Cómite Escolar De Convivencia.</p>
      </div>

      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li><a href="quienes-somos.php">Quiénes Somos</a></li>
          <li><a href="manual.php">Manual</a></li>
          <li><a href="actividades.php">Actividades</a></li>
          <li><a href="equipo.php">Equipo</a></li>
          <li><a href="contacto.php">Contáctanos</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© 2026 COESCON — Todos los derechos reservados</span>
      <div style="display:flex;gap:1.5rem;">
        <a href="#">Política de privacidad</a>
        <a href="#">Términos de uso</a>
      </div>
    </div>
  </footer>
</div>
</body>
</html>