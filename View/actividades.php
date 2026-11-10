<?php
/**
 * actividades.php
 * Página "Actividades" del sitio COESCON (Comité Escolar de Convivencia).
 * Muestra las actividades y proyectos del consejo en un carrusel y el
 * calendario de eventos incrustado desde Google Calendar.
 *
 * Secciones del archivo:
 *   1. Sesión PHP
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Actividades (carrusel)
 *   6. Calendario (Google Calendar)
 *   7. Pie de página (footer)
 */

/* ========== 1. SESIÓN PHP ==========
   Inicia o reanuda la sesión del usuario. Debe ejecutarse antes de cualquier salida HTML. */
session_start();
?>
<!DOCTYPE html>
<!-- Página de actividades y proyectos del Consejo Estudiantil. -->
<html lang="es">

<!-- ========== 2. CABECERA DEL DOCUMENTO ========== -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManualitOnline — Actividades</title>

  <!-- Fuentes -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=Pirata+One&display=swap" rel="stylesheet">

  <!-- Estilos y script principal -->
  <link rel="stylesheet" href="Static/CSS/styles.css">
  <script src="Static/JS/Script.js" defer></script>

  <!-- Ícono de la pestaña -->
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
</head>

<body>

  <!-- 3. ACCESIBILIDAD -->
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

  <!-- 4. MENÚ  -->
  <?php include("Static/INCLUDE/header.php"); ?>

  <!-- 5. ACTIVIDADES (CARRUSEL) -->
  <section id="actividades">

    <!-- Encabezado de la sección -->
    <div class="carousel-header reveal">
      <center><div class="section-label">Actividades</div></center>
      <center><h2 class="section-title" style="color:white;">Hacemos que las<br>cosas sucedan</h2></center>
      <center><p class="section-sub">Desde ferias académicas hasta marchas por los derechos estudiantiles. Cada acción cuenta.</p></center>
    </div>

    <!-- Pista del carrusel -->
    <div class="carousel-track-wrapper">
      <div class="carousel-track" id="carousel">

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#0C447C,#378ADD);">🧑‍🏫</div>
            <div class="slide-body">
              <div class="slide-tag">Academia</div>
              <h3>Foro de profesores</h3>
              <p>Un evento o reunión donde los docentes comparten experiencias y metodologías de enseñanza.</p>
            </div>
          </div>
        </div>

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#185FA5,#85B7EB);">🧑‍🎓 </div>
            <div class="slide-body">
              <div class="slide-tag">Academia</div>
              <h3>Foro de Estudiantes</h3>
              <p>Un espacio para que los estudiantes expresen sus preocupaciones, propuestas y participen en la toma de decisiones.</p>
            </div>
          </div>
        </div>

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#C9A84C,#F0D080);">🤝</div>
            <div class="slide-body">
              <div class="slide-tag">Cultura</div>
              <h3>Semana de Convivencia</h3>
              <p>Es un espacio institucional para fortalecer el respeto, la empatía y el diálogo en la comunidad.</p>
            </div>
          </div>
        </div>

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#042C53,#185FA5);">🔗</div>
            <div class="slide-body">
              <div class="slide-tag">Bienestar</div>
              <h3>Trabajo Colaborativo</h3>
              <p>Actividades que fomentan la cooperación y el trabajo en equipo entre los miembros de la comunidad universitaria.</p>
            </div>
          </div>
        </div>

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#0C447C,#42A5F5);">🙋‍♂️🗳️</div>
            <div class="slide-body">
              <div class="slide-tag">Democracia</div>
              <h3>Participación Ciudadana</h3>
              <p>Un espacio para que los estudiantes expresen sus preocupaciones, propuestas y participen en la toma de decisiones.</p>
            </div>
          </div>
        </div>

        <div class="carousel-slide">
          <div class="slide-card">
            <div class="slide-img" style="background:linear-gradient(135deg,#185FA5,#1DE9B6);">🧘</div>
            <div class="slide-body">
              <div class="slide-tag"></div>
              <h3>Eudoemociones</h3>
              <p>Actividades para fomentar el bienestar emocional y la regulación de las emociones en la comunidad educativa.</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Controles del carrusel -->
    <div class="carousel-controls">
      <button class="carousel-btn" onclick="moveCarousel(-1)">←</button>
      <div class="carousel-dots" id="carousel-dots">
        <button class="carousel-dot active"></button>
      </div>
      <button class="carousel-btn" onclick="moveCarousel(1)">→</button>
    </div>
  </section>

  <!--  6. CALENDARIO  -->
  <section id="calendario" class="calendar-section">

    <!-- Encabezado de la sección -->
    <div class="calendar-header">
      <center><div class="section-label">Calendario</div></center>
      <center><h2 class="section-title">Calendario de actividades</h2></center>
      <center><p class="section-sub">Consulta las próximas actividades y eventos de COESCON.</p></center>
      <br>
    </div>

    <div></div>

    <!-- Calendario incrustado -->
    <center><iframe src="https://calendar.google.com/calendar/embed?src=thomaslm1002%40gmail.com&ctz=America%2FBogota" style="border: 0" width="800" height="600" frameborder="0" scrolling="si"></iframe></center>


    </div>

  </section>

  <!--  7. FOOTER  -->
  <footer>
    <div class="footer-grid">

      <div class="footer-brand">
        <div class="logo">COESCON</div>
        <p>Cómite Escolar De Convivencia.</p>
      </div>

      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="quienes-somos.php">Quiénes Somos</a></li>
          <li><a href="manual.php">Manual</a></li>
          <li><a href="actividades.php">Actividades</a></li>
          <li><a href="equipo.php">Equipo</a></li>
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

<!-- Este </div> no tiene etiqueta de apertura en este archivo; probablemente
     se abre dentro de header.php. Si no es así, se puede eliminar. -->
</div>
</body>
</html>