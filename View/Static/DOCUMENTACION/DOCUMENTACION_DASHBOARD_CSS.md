# Documentación técnica de `css/dashboard.css`

## Propósito

Define la interfaz del panel administrativo: barra lateral, barra superior, tarjetas de resumen y botón de usuario.

## Componentes y selectores

| Selector | Función |
|---|---|
| `*` | Reinicia márgenes y rellenos, aplica `border-box` y la fuente Poppins. |
| `body` | Establece el fondo gris claro del panel. |
| `.container` | Contenedor flex que dispone sidebar y contenido principal. |
| `.sidebar`, `.logo`, `.sidebar ul`, `.sidebar ul li`, `.sidebar ul li i` | Construyen y dan formato al menú lateral. |
| `.sidebar ul li:hover` | Resalta un elemento del menú y muestra cursor interactivo. |
| `.main` | Ocupa el espacio horizontal que queda junto a la barra lateral. |
| `.navbar`, `.user` | Barra superior blanca y texto del usuario. |
| `.content` | Añade el espacio interior del contenido. |
| `.cards`, `.card`, `.card i`, `.card h2`, `.card p` | Rejilla adaptable y presentación de las tarjetas de información. |
| `.card:hover` | Eleva visualmente la tarjeta al pasar el cursor. |
| `.user-button`, `.user-button:hover` | Botón reutilizable azul con retroalimentación hover. |

## Diseño adaptable

En `@media (max-width: 768px)`, la sidebar pasa de 230 px a 70 px, reduce logo y espaciados, oculta `.sidebar ul li span`, elimina el margen de iconos y reduce el título de la barra superior.

## Dependencias visuales

Usa Poppins, aunque este archivo no importa la fuente; debe cargarse desde el documento HTML o una hoja compartida. Los iconos de `.card i` y `.sidebar ul li i` requieren la biblioteca de iconos usada por el HTML.
