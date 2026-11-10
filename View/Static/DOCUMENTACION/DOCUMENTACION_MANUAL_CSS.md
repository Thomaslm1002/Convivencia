# Documentación técnica de `css/manual.css`

## Propósito

Define la página pública del manual: hero, secciones informativas, tarjetas, cronología, preguntas frecuentes, llamada a la acción, pie de página y calendario.

## Sistema visual

El bloque inicial declara tokens para fondos, superficies, tipografía, acento turquesa, ámbar, bordes y sombras. La página usa Inter, un ancho máximo de 1140 px y una paleta azul con superficies claras.

> Observación: el selector de variables está escrito como `root`, no `:root`; por tanto, las variables no se aplicarán globalmente salvo que exista un elemento `<root>`. Además, hay bloques comentados/desbalanceados cerca de la navegación y un `}` final sin pareja aparente. Conviene corregirlos antes de confiar en todos los estilos.

## Componentes y selectores

| Grupo | Selectores principales | Función |
|---|---|---|
| Base | `*`, `html`, `body`, `a`, `img`, `button`, `.container` | Normalización, desplazamiento suave, tipografía, medios y contenedor centrado. |
| Cabecera | `.topbar` | Barra superior fija con transparencia y desenfoque. Las reglas de `.nav-wrap`, `.brand`, `.main-nav` y `.nav-toggle` están dentro de comentarios y no se aplican. |
| Hero | `.hero`, `.hero::before`, `.hero-grid`, `.eyebrow`, `.hero-copy`, `.hero-actions`, `.hero-list`, `.hero-panel`, `.stat-card`, `.card-strong` | Portada con degradado, contenido en dos columnas, botones, etiquetas y tarjetas de datos. |
| Botones | `.btn`, `.btn-primary`, `.btn-secondary` | Botón base y variantes primaria/ secundaria. |
| Secciones | `.section`, `.section-head`, `.light`, `.section-dark`, `.section-soft` | Espaciado y variantes de fondos/encabezados. |
| Tarjetas | `.feature-grid`, `.feature-card`, `.icon`, `.rules-grid`, `.rule-card`, `.rule-tag` | Rejillas de características y reglas. |
| Información | `.info-grid`, `.info-panel`, `.info-panel.alt` | Paneles informativos en dos columnas. |
| Cronología | `.timeline`, `.timeline-step`, `.timeline-step::after` | Pasos con conectores visuales. |
| FAQ | `.faq-wrap`, `.faq-list`, `.faq-item`, `.faq-question`, `.faq-answer`, `.faq-item.open` | Acordeón: `.open` cambia el símbolo y muestra la respuesta. |
| Cierre | `.cta-section`, `.cta-box`, `.site-footer`, `.footer-wrap` | Llamada a la acción y pie de página. |
| Calendario | `.calendar-section`, `.calendar-header`, `.calendar-container`, `.calendar-container iframe` | Contenedor adaptable para un calendario embebido. |

## Diseño adaptable

`@media (max-width: 980px)` reduce las rejillas de cuatro columnas a dos y apila hero/FAQ. `@media (max-width: 680px)` deja en una columna las rejillas, reduce el hero y apila acciones, CTA y pie de página.

## Interacción esperada

El acordeón depende de añadir/quitar `.open` en cada `.faq-item` mediante JavaScript. La navegación responsive está comentada, por lo que el botón de menú no se comportará visualmente hasta reactivar y corregir ese bloque.
