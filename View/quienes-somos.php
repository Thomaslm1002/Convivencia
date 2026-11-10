<?php
/**
 * quienes-somos.php
 * Página "Quiénes Somos" del sitio COESCON (Comité Escolar de Convivencia).
 * Presenta la identidad y el propósito del proyecto ManualitOnline y de la
 * Institución Educativa Gilberto Alzate Avendaño, con el estilo de una
 * carta antigua ("pirate-letter") firmada por el rector.
 *
 * Secciones del archivo:
 *   1. Sesión PHP
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Quiénes Somos (carta de identidad institucional)
 *   6. Pie de página (footer)
 */

/*  1. SESIÓN PHP  */
session_start();
?>
<!DOCTYPE html>
<!-- Página de identidad y propósito del Consejo Estudiantil COESCON. -->
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManualitOnline — Quiénes Somos</title>

  <!-- Fuentes -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=Pirata+One&display=swap" rel="stylesheet">

  <!-- Estilos e ícono -->
  <link rel="stylesheet" href="Static/CSS/styles.css">
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">

  <!-- Script principal -->
  <script src="Static/JS/Script.js" defer></script>
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

  <!--  5. QUIÉNES SOMOS  -->
  <section id="quienes" class="quienes-pirate">
    <div class="container">

      <!-- Encabezado de la sección -->
      <div class="section-header reveal" style="position:relative;z-index:2;">
        <center><div class="section-tag">Conócenos</div></center>
        <center><h2 class="section-title" style="color:#f4e4b0;">Quiénes Somos</h2></center>
        <center><div class="section-line"></div></center>
      </div>

      <!-- Carta de identidad institucional -->
      <div class="pirate-letter reveal">
        <div class="pirate-paper">

          <!-- Sello y adornos de las cuatro esquinas -->
          <div class="letter-seal">⚜️</div>
          <span class="corner-ornament tl">✦</span>
          <span class="corner-ornament tr">✦</span>
          <span class="corner-ornament bl">✦</span>
          <span class="corner-ornament br">✦</span>

          <!-- Encabezado de la carta -->
          <div class="letter-header">
            <div class="letter-title">Institución Educativa Gilberto Alzate Avendaño</div>
            <div class="letter-subtitle">— Carta de Identidad Institucional —</div>
          </div>

          <!-- Lema de la institución -->
          <div class="letter-date">EL ALZATE VIVE POR VOS</div>

          <!-- Cuerpo de la carta: el primer párrafo lleva letra capital (drop-cap) -->
          <div class="letter-body">
            <p class="drop-cap">ManualitOnline es un proyecto desarrollado para facilitar el acceso y la comprensión del Manual de Convivencia de la Institución Educativa Gilberto Álzate Avendaño.</p>
            <p>Nuestra plataforma busca ofrecer un espacio digital sencillo, organizado e interactivo, donde estudiantes y docentes puedan consultar información importante de manera rápida y fácil.</p>
            <p>También contamos con un espacio dedicado a COESCON, donde se pueden conocer sus actividades, novedades y recibir sugerencias de los estudiantes para mejorar la convivencia escolar.</p>
            <p>Nuestro propósito es fortalecer la comunicación entre la comunidad educativa y promover el conocimiento, la participación y el cumplimiento de las normas de convivencia.</p>
          </div>

          <!-- Firma del rector -->
          <div class="letter-signature">
            <div class="sig-name">Humberto Bermudez Cardona · Rector</div>
            <div class="sig-title">Insitución Educativa Gilberto Alzate Avendaño ✦ 1962</div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!--  6. PIE DE PÁGINA  -->
  <footer>
    <div class="footer-grid">

      <div class="footer-brand">
        <div class="logo">COESCON</div>
        <p>Cómite Escolar De Convivencia</p>
      </div>

      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="index.php">Inicio</a></li>
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