<?php
/**
 * manual.php
 * Página "Manual de convivencia" del sitio COESCON (Comité Escolar de
 * Convivencia). Presenta los principios, normas, derechos y deberes de la
 * institución, el proceso para atender una situación, preguntas frecuentes
 * y la descarga del manual oficial en PDF.
 *
 * Secciones del archivo:
 *   1. Sesión PHP
 *   2. Cabecera del documento (<head>)
 *   3. Accesibilidad
 *   4. Menú superior (header)
 *   5. Contenido principal
 *      5.1 Hero (introducción)
 *      5.2 Valores y principios institucionales
 *      5.3 Normas esenciales
 *      5.4 Derechos y deberes
 *      5.5 Proceso de atención
 *      5.6 Preguntas frecuentes
 *      5.7 Descarga del manual (CTA)
 *   6. Pie de página (footer)
 *   7. Scripts
 */

/*  1. SESIÓN PHP: Iniciar la sesión para almacenar la información del usuario. Debe ejecutarse antes de cualquier salida HTML. */
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Manual de convivencia de COESCON.">
  <title>ManualitOnline -- Manual de convivencia</title>
  <!-- Ícono de la pestaña -->
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
  <!-- Estilos -->
  <link rel="stylesheet" href="Static/CSS/styles.css">
  <link rel="stylesheet" href="Static/CSS/Manual.css">
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
  <br>
  <!--  5. CONTENIDO PRINCIPAL -->
  <main>
    <!--  5.1 HERO (INTRODUCCIÓN)  -->
    <section class="hero">
      <div class="container hero-grid">

        <div class="hero-copy">
          <span class="eyebrow">Manual de convivencia</span>
          <h1>Construimos una comunidad con respeto, conciencia y dignidad.</h1>
          <p>
            Este manual recoge los principios, derechos y deberes que orientan nuestra convivencia,
            fortalecen la identidad del grupo y promueven soluciones justas, humanas y responsables.
          </p>

          <div class="hero-actions">
            <a href="#principios" class="btn btn-primary">Ver principios</a>
            <a href="#derechos" class="btn btn-secondary">Nuestros derechos</a>
          </div>

          <ul class="hero-list" aria-label="Valores principales">
            <li>Respeto</li>
            <li>Participación</li>
            <li>Seguridad</li>
          </ul>
        </div>

        <div class="hero-panel" aria-label="Resumen del manual">
          <div class="stat-card card-strong">
            <span class="label">Base</span>
            <strong>21</strong>
            <p>Estos son los pilares que tiene nuestra institución.</p>
          </div>
          <div class="stat-card">
            <span class="label">Objetivo</span>
            <h3>Ambiente sano</h3>
            <p>Garantizar un espacio de aprendizaje seguro, equitativo y digno para todas las personas.</p>
          </div>
        </div>

      </div>
    </section>

    <!--  5.2 VALORES Y PRINCIPIOS INSTITUCIONALES  -->
    <section id="principios" class="section container">

      <div class="section-head">
        <span class="eyebrow accent" color="black">Valores y Principios Institucionales</span>
        <h2>Lo que orienta nuestra convivencia</h2>
      </div>

      <div class="feature-grid">

        <article class="feature-card">
          <div class="icon">1</div>
          <h3>Autonomía</h3>
          <p>Promueve la capacidad de tomar decisiones informadas y responsables, desarrollar el pensamiento crítico y construir un criterio propio.</p>
        </article>

        <article class="feature-card">
          <div class="icon">2</div>
          <h3>Trabajo Colaborativo</h3>
          <p>Fomenta la cooperación y el aprendizaje colectivo mediante el trabajo conjunto, fortaleciendo la comunicación, la empatía y el liderazgo.</p>
        </article>

        <article class="feature-card">
          <div class="icon">3</div>
          <h3>Mediación Escolar</h3>
          <p>Promueve la resolución pacífica de conflictos mediante el diálogo, la escucha activa, la empatía y la búsqueda de acuerdos.</p>
        </article>

        <article class="feature-card">
          <div class="icon">4</div>
          <h3>Solidaridad</h3>
          <p>Fortalece la empatía, el apoyo mutuo y el compromiso con el bienestar colectivo, la sociedad y el cuidado del medio ambiente.</p>
        </article>

        <article class="feature-card">
          <div class="icon">5</div>
          <h3>Respeto a la Diversidad</h3>
          <p>Reconoce y valora la pluralidad cultural, étnica, de género y de pensamiento, promoviendo la igualdad y el respeto.</p>
        </article>

        <article class="feature-card">
          <div class="icon">6</div>
          <h3>Participación Ciudadana</h3>
          <p>Incentiva la participación activa y responsable de los estudiantes en la vida democrática y en la transformación de sus comunidades.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">7</div>
          <h3>Inclusión y diversidad</h3>
          <p>Promueve la participación justa de todas las personas, reconociendo las diferencias y previniendo la discriminación.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">8</div>
          <h3>Desarrollo del potencial humano</h3>
          <p>Reconoce las capacidades de cada persona y acompaña su crecimiento cognitivo, emocional, social y ético.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">9</div>
          <h3>Adaptabilidad</h3>
          <p>Desarrolla la capacidad de afrontar cambios y situaciones nuevas con creatividad, resiliencia y disposición para aprender.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">10</div>
          <h3>Pensamiento crítico</h3>
          <p>Permite analizar y valorar información de manera reflexiva e independiente para tomar decisiones fundamentadas.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">11</div>
          <h3>Innovación educativa</h3>
          <p>Impulsa la creatividad, nuevas estrategias y tecnología para mejorar los procesos de enseñanza y aprendizaje.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">12</div>
          <h3>Ética en el uso de la ciencia y la tecnología</h3>
          <p>Promueve un uso responsable, seguro, crítico y justo de la ciencia y la tecnología.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">13</div>
          <h3>Aprendizaje situado y contextualizado</h3>
          <p>Relaciona los aprendizajes con la realidad y las experiencias de los estudiantes para responder a los retos de su entorno.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">14</div>
          <h3>Comunicación</h3>
          <p>Favorece la expresión clara, asertiva y respetuosa de ideas y sentimientos, fortaleciendo el diálogo.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">15</div>
          <h3>Respeto</h3>
          <p>Reconoce la dignidad de cada persona y promueve relaciones basadas en la tolerancia, la empatía y la inclusión.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">16</div>
          <h3>Equidad</h3>
          <p>Busca garantizar igualdad de oportunidades y condiciones adecuadas para que todas las personas desarrollen su potencial.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">17</div>
          <h3>Creatividad</h3>
          <p>Estimula la generación de ideas y soluciones originales, promoviendo la exploración y la innovación.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">18</div>
          <h3>Responsabilidad social y ambiental</h3>
          <p>Impulsa el compromiso con el bienestar de la comunidad, el desarrollo sostenible y la protección del medio ambiente.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">19</div>
          <h3>Cooperación</h3>
          <p>Promueve el trabajo conjunto mediante el intercambio de conocimientos, esfuerzos y responsabilidades.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">20</div>
          <h3>Integridad</h3>
          <p>Fortalece la honestidad, transparencia y coherencia entre los valores, las decisiones y las acciones.</p>
        </article>

        <article class="feature-card principio-oculto">
          <div class="icon">21</div>
          <h3>Gratitud</h3>
          <p>Fomenta el reconocimiento y la valoración de las oportunidades, aprendizajes y apoyo recibido de los demás.</p>
        </article>
      </div>

      <!-- Botones para mostrar u ocultar los principios 7 a 21. "Ocultar" empieza escondido; principios.js alterna ambos. -->
      <div class="principios-btn-container">
        <button id="btnPrincipios" type="button">
          Ver más
        </button>
        <button id="btnOcultarPrincipios" type="button" style="display: none;">
          Ocultar
        </button>
      </div>

    </section>

    <!--  5.3 NORMAS ESENCIALES  -->
    <section class="section section-dark">
      <div class="container">

        <div class="section-head light">
          <span class="eyebrow accent">Normas esenciales</span>
          <h2>Reglas que protegen a la comunidad</h2>
        </div>

        <div class="rules-grid">
          <article class="rule-card">
            <span class="rule-tag">1</span>
            <h3>Trato digno</h3>
            <p>Se prohíben el acoso, la discriminación, las amenazas y cualquier conducta que afecte la integridad de otras personas.</p>
          </article>
          <article class="rule-card">
            <span class="rule-tag">2</span>
            <h3>Uso responsable</h3>
            <p>Los espacios, herramientas y recursos de la institución deben usarse con cuidado, sentido colectivo y finalidad académica.</p>
          </article>
          <article class="rule-card">
            <span class="rule-tag">3</span>
            <h3>Honestidad</h3>
            <p>La autenticidad en el trabajo académico, la comunicación y las decisiones fortalece la confianza institucional.</p>
          </article>
          <article class="rule-card">
            <span class="rule-tag">4</span>
            <h3>Diálogo</h3>
            <p>Antes de resolver un conflicto, se prioriza la escucha, la conversación y la mediación con actitud constructiva.</p>
          </article>
        </div>

      </div>
    </section>

    <!--  5.4 DERECHOS Y DEBERES  -->
    <section id="derechos" class="section container">

      <div class="section-head">
        <span class="eyebrow accent">Derechos y deberes</span>
        <h2>Un marco para vivir con dignidad</h2>
      </div>

      <div class="info-grid">
        <article class="info-panel">
          <h3>Derechos</h3>
          <ul>
            <li>Ser tratado con respeto y sin discriminación.</li>
            <li>Participar en un ambiente seguro y saludable.</li>
            <li>Expresar opiniones con libertad y responsabilidad.</li>
            <li>Solicitar orientación frente a situaciones de conflicto.</li>
          </ul>
        </article>

        <article class="info-panel alt">
          <h3>Deberes</h3>
          <ul>
            <li>Cumplir con las normas institucionales y acuerdos sociales.</li>
            <li>Respetar la propiedad, la diferencia y el espacio de otros.</li>
            <li>Contribuir a un clima de respeto, colaboración y solidaridad.</li>
            <li>Reportar situaciones que afecten la convivencia de forma responsable.</li>
          </ul>
        </article>
      </div>

    </section>

    <!--  5.5 PROCESO DE ATENCIÓN  -->
    <section class="section section-soft">
      <div class="container">

        <div class="section-head">
          <span class="eyebrow accent">Proceso</span>
          <h2>Cómo se atiende una situación</h2>
        </div>

        <div class="timeline">
          <article class="timeline-step">
            <span>1</span>
            <h3>Escucha</h3>
            <p>Se recibe la denuncia o inquietud con atención, respeto y confidencialidad.</p>
          </article>
          <article class="timeline-step">
            <span>2</span>
            <h3>Valoración</h3>
            <p>Se revisa lo ocurrido, se identifican hechos y se analiza la gravedad de la situación.</p>
          </article>
          <article class="timeline-step">
            <span>3</span>
            <h3>Acción</h3>
            <p>Se aplican medidas proporcionales y pedagógicas según el caso y el contexto.</p>
          </article>
          <article class="timeline-step">
            <span>4</span>
            <h3>Seguimiento</h3>
            <p>Se acompaña la reparación, la reflexión y la prevención para evitar repetición.</p>
          </article>
        </div>

      </div>
    </section>

    <!--  5.6 PREGUNTAS FRECUENTES  -->
    <section class="section container">
      <div class="faq-wrap">

        <div class="faq-intro">
          <span class="eyebrow accent">Preguntas frecuentes</span>
          <h2>Lo más importante, explicado con claridad</h2>
        </div>

        <div class="faq-list">

          <div class="faq-item open">
            <button class="faq-question" type="button" aria-expanded="true">
              ¿Qué es la convivencia escolar?
            </button>
            <div class="faq-answer">
              <p> es el conjunto de relaciones humanas, interacciones y dinámicas que se establecen entre todos los miembros de una comunidad educativa, como estudiantes, docentes, directivos y familias.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false">
              ¿Qué hacer si alguien agrede o discrimina a otra persona?
            </button>
            <div class="faq-answer">
              <p>Si eres testigo o víctima de una agresión o discriminación, debes priorizar la seguridad física alejándote del peligro, documentar el hecho tomando fotos, videos o datos de testigos, y denunciar formalmente ante la Fiscalía General de la Nación, la Policía Nacional o acudir a la Defensoría del Pueblo para recibir asesoría legal gratuita.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false">
              ¿Las normas se aplican a todas las personas por igual?
            </button>
            <div class="faq-answer">
              <p>Sí. La diferencia está en la forma de atender cada caso, aplicando criterios de proporcionalidad, justicia y respeto al debido proceso.</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!--  5.7 DESCARGA DEL MANUAL (CTA) -->
    <section class="cta-section">
      <div class="container cta-box">
        <div>
          <span class="eyebrow accent">Documento oficial</span>
          <h2>Consulta la guía completa</h2>
        </div>
        <a href="Static/PDF/MANUAL 2026 v1.pdf" target="_blank" rel="noopener" class="btn btn-primary">Descargar manual</a>
      </div>
    </section>

  </main>

  <!--  6. Footer   -->
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
          <li><a href="quienes-somos.php">Quienes Somos</a></li>
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

  <!--  7. SCRIPTS  -->
  <script src="Static/JS/script.js" defer></script>
  <script src="Static/JS/manual.js" defer></script>
  <script src="Static/JS/principios.js" defer></script>
</body>
</html> 