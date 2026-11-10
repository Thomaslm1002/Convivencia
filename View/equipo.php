<?php
/**
 * equipo.php
 * Página "Equipo" del sitio COESCON (Comité Escolar de Convivencia).
 *
 * Secciones del archivo:
 *   1. Sesión PHP
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Equipo (tarjetas de integrantes)
 *   6. Pie de página (footer)
 */

// 1. SESIÓN PHP: Inicia o reanuda la sesión del usuario. Debe ejecutarse antes de cualquier salida HTML. 
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManualitOnline — Equipo</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=Pirata+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Static/CSS/styles.css">
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
  <script src="static/JS/script.js" defer></script>
</head>
<body>

<!--  3. ACCESIBILIDAD  -->
<button id="a11y-btn" aria-label="Accesibilidad" onclick="toggleA11y()">
  <svg viewBox="0 0 24 24"><path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8 5H4l3 8h3l1 7h2l1-7h3z"/></svg>
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

  <!--  4. MENÚ  -->
  <?php include("Static/INCLUDE/header.php"); ?>

  <!--  5. EQUIPO  -->
  <section id="equipo">
    <div class="container">
      <div class="reveal">
        <center><div class="section-label">Nuestro Equipo</div></center>
        <center><h2 class="section-title">Las personas detrás<br>del cambio</h2></center>
        <center><p class="section-sub">Estudiantes comprometidos, elegidos democráticamente, que dedican su tiempo y talento a servir a la comunidad.</p></center>
      </div>
      <div class="team-grid reveal">
                <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#185FA5,#85B7EB);">HB<div class=""></div></div>
          <h3>Humberto Bermúdez Cardonas</h3>
          <div class="role">Rector Del Colegio</div>
          <p class="bio"></p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#042C53,#378ADD);">AC<div></div></div>
          <h3>Aleider de Jesús Céspedes Sarrazola</h3>
          <div class="role">Coordinador y Líder de COESCON</div>
          <p class="bio">Licenciado de la Universidad de Antioquia</p>
          <div class="team-social">
            <button class="social-btn" title="Email">✉</button>
            <button class="social-btn" title="LinkedIn">in</button>
            <button class="social-btn" title="Instagram">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#C9A84C,#F0D080);color:var(--blue-900);">RB</div>
          <h3>Raúl Eduardo Betancourt Ossa</h3>
          <div class="role">Secretario y Fundador</div>
          <p class="bio">Sociologo UDEA</p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">DJ</div>
          <h3>Daniela Jaramillo Puerta</h3>
          <div class="role">Profesional de Apoyo Institucional (PAI) del Programa Escuela Entorno </div>
          <p class="bio">Psicóloga egresada del Tecnológico de Antioquia Institución Universitaria</p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">AV</div>
          <h3>Angela María Vallejo Quintero</h3>
          <div class="role">Profesional de Apoyo Institucional (PAI) del Programa Escuela Entorno </div>
          <p class="bio">Psicóloga egresada de la Universidad Católica Luis Amigo. </p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">AG</div>
          <h3>Alexandra María Giraldo García </h3>
          <div class="role">Miembro y Fundadora</div>
          <p class="bio">Maestrante en Educación y DDHH </p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">JO</div>
          <h3>Jesline Osorio Giraldo </h3>
          <div class="role">Miembro</div>
          <p class="bio">Magister en Educación y Desarrollo Humano del Cinde- Universidad de Manizales</p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
      <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">HM</div>
          <h3>Hilda Natividad Morales Luna </h3>
          <div class="role">Miembro</div>
          <p class="bio">Especialista en enseñanza de aplicación de TICS para la enseñanza. </p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">YC</div>
          <h3>Yessica Carmona Alvarez  </h3>
          <div class="role">Miembro</div>
          <p class="bio">Magister en Educación Inclusiva e Intercultural - Universidad de la Rioja </p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">MO</div>
          <h3>María Salomé Orozco Zapata</h3>
          <div class="role">Personera 2026 Del IEGAA</div>
          <p class="bio">Estudiante en formación</p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0C447C,#378ADD);">AM</div>
          <h3>Anna Sophie Mejía Alzate</h3>
          <div class="role">Representante Estudiante 2026 Del IEGAA</div>
          <p class="bio">Estudiante en formación</p>
          <div class="team-social">
            <button class="social-btn">✉</button>
            <button class="social-btn">in</button>
            <button class="social-btn">📷</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--  Footer  -->
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