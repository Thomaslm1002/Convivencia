<?php
/**
 * index.php
 * Página de inicio del sitio COESCON (Comité Escolar de Convivencia).
 * Presenta el portal: bienvenida (hero), accesos a las secciones del sitio
 * y un bloque de características destacadas.
 *
 * Secciones del archivo:
 *   1. Sesión PHP
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Contenido principal
 *      5.1 Hero (bienvenida)
 *      5.2 Explora cada área del sitio
 *      5.3 Destacado
 *   6. Pie de página (footer)
 *   7. Scripts
 */

/*  1. SESIÓN PHP  */
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManualitOnline — Comité Escolar de Convivencia</title>

  <!-- Ícono de la pestaña -->
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">

  <!-- Fuentes -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=Pirata+One&display=swap" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="Static/CSS/styles.css">
</head>

<body>
  <?php if (isset($_GET['ok']) && $_GET['ok'] === 'publicada'): ?>
      <div class="mensaje-publicacion">
          <span>✓</span>
          ¡La noticia se publicó correctamente!
      </div>
  <?php endif; ?>

  <!--  3. ACCESIBILIDAD  -->
  <button id="a11y-btn" aria-label="Accesibilidad" aria-expanded="false" aria-controls="a11y-panel" onclick="toggleA11y()">
    <svg viewBox="0 0 24 24">
      <path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8 5H4l3 8h3l1 7h2l1-7h3z"/>
    </svg>
  </button>

  <div id="a11y-panel" role="dialog" aria-label="Opciones de accesibilidad">
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
  <!-- Fin del widget de accesibilidad -->

  <!--  4. MENÚ SUPERIOR  -->
  <?php include("Static/INCLUDE/header.php"); ?>

  <!--  5. CONTENIDO PRINCIPAL  -->
  <main>

    <!--  5.1 HERO (BIENVENIDA)  -->
    <section class="hero">
      <div class="container hero-content reveal">

        <div class="hero-text">
          <p class="section-label">Comité Escolar de Convivencia</p>
          <h1>Bienvenido a COESCON</h1>
          <p class="hero-lead">Impulsamos la participación estudiantil con claridad, actividades relevantes y espacios de voz dentro de la universidad.</p>

          <div class="hero-actions">
            <a class="button button-primary" href="quienes-somos.php">Quiénes Somos</a>
            <a class="button button-secondary" href="actividades.php">Actividades</a>
          </div>

          <div class="hero-summary">
            <div>
              <strong>Manual</strong>
              <span>Para que sepas sobre el manual de convivencia.</span>
            </div>
            <div>
              <strong>+ Apoyo</strong>
              <span>Apoyo real para tu experiencia.</span>
            </div>
            <div>
              <strong>+ Participación</strong>
              <span>Más estudiantes involucrados en decisiones.</span>
            </div>
          </div>
        </div>

        <div class="hero-visual">
          <div class="hero-card-stack">
            <div class="card">Actividades</div>
            <div class="card">Historias</div>
            <div class="card">Equipo</div>
          </div>
        </div>

      </div>
    </section>

    <!--  5.2 EXPLORA CADA ÁREA DEL SITIO  -->
    <section id="home-sections" class="section-block reveal">
      <div class="container">
        <div class="section-label">Secciones</div>
        <h2 class="section-title">Explora cada área del sitio</h2>
        <p class="section-sub">Navega por las páginas dedicadas a nuestra historia, actividades, equipo y contacto.</p>

        <div class="home-grid">
          <a href="quienes-somos.php" class="home-card">
            <h3>Quiénes Somos</h3>
            <p>Conoce nuestro propósito, valores y misión como Comité Escolar de Convivencia.</p>
          </a>
          <a href="actividades.php" class="home-card">
            <h3>Actividades</h3>
            <p>Explora los proyectos y eventos en los que puedes participar como Comité Escolar de Convivencia.</p>
          </a>
          <a href="equipo.php" class="home-card">
            <h3>Equipo</h3>
            <p>Conoce al grupo de estudiantes detrás de nuestras iniciativas.</p>
          </a>
          <a href="contacto.php" class="home-card">
            <h3>Contáctanos</h3>
            <p>Envía tus dudas, propuestas o deseos de participar para saber quién está detrás de nuestras iniciativas.</p>
          </a>
        </div>
      </div>
    </section>

    <!--  5.3 DESTACADO  -->
    <section class="section-block reveal">
      <div class="container">
        <div class="section-label">Destacado</div>
        <h2 class="section-title">Un espacio más completo para ti</h2>
        <p class="section-sub">Estas pequeñas secciones te ayudan a encontrar rápido lo más importante del sitio.</p>

        <div class="home-grid">
          <div class="home-card">
            <h3>Información clara</h3>
            <p>Todo el contenido ordenado para que no pierdas tiempo buscando lo que necesitas.</p>
          </div>
          <div class="home-card">
            <h3>Participa fácil</h3>
            <p>Encuentra las actividades y propuestas abiertas para estudiantes desde el primer vistazo.</p>
          </div>
          <div class="home-card">
            <h3>Contacto directo</h3>
            <p>Siempre hay una forma rápida de comunicarte con el equipo y recibir respuesta.</p>
          </div>
          <div class="home-card">
            <h3>Comunidad unida</h3>
            <p>Promueve el respeto, la colaboración y la buena convivencia escolar.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!--  6. Footer  -->
  <footer class="footer">
    <div class="container footer-grid reveal">

      <div>
        <a class="brand footer-brand" href="index.php">COESCON</a>
        <p>CComité Escolar de Convivencia</p>
      </div>

      <div class="footer-col">
        <h4>Acceso rápido</h4>
        <ul>
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
      <div class="footer-links">
        <a href="#">Política de privacidad</a>
        <a href="#">Términos de uso</a>
      </div>
    </div>
  </footer>
</div>
  <!--  7. SCRIPTS  -->
  <script src="Static/JS/Script.js"></script>
</body>
</html>