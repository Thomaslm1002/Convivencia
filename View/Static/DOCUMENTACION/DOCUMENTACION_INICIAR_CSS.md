# Documentación técnica de `css/iniciar.css`

## Propósito

Estiliza las pantallas de inicio de sesión: tarjeta translúcida, pestañas, campos, recuperación/registro, redes sociales y control de contraseña.

## Componentes y selectores

| Grupo de selectores | Función |
|---|---|
| `@import`, `*`, `body` | Carga Poppins, normaliza las cajas y centra la vista sobre un fondo degradado azul. |
| `.container`, `.login-container` | Tarjetas de login con efecto vidrio (`backdrop-filter`), sombra y bordes redondeados. |
| `.logo`, `h1`, `h1 span`, `.login-subtitle`, `.subtitulo` | Cabecera visual, marca y textos de introducción. |
| `.tabs`, `.tabs button`, `.tabs .activo` | Navegación de pestañas y estado seleccionado. |
| `label`, `input`, `input::placeholder`, `input:focus`, `.form-group label` | Etiquetas, entradas, marcador de posición y foco de formularios. |
| `.btn-login`, `.btn-login:hover`, `.btn`, `.btn:hover` | Botones principales con cambio de color y/o elevación al pasar el cursor. |
| `.texto`, `.texto a`, `.texto a:hover`, `hr` | Textos auxiliares, enlaces y separador. |
| `.redes`, `.redes a`, `.redes a:hover` | Botones circulares de redes sociales. |
| `.password`, `.show-password` | Contexto posicionado y botón para mostrar u ocultar la contraseña. |
| `.remember-me`, `.remember-me input` | Alineación y tamaño de la opción “recordarme”. |

## Interacción esperada

Las clases `.activo` y el control `.show-password` requieren JavaScript para cambiar de pestaña y visibilidad de contraseña; el CSS solo representa sus estados.

## Diseño adaptable

No hay media queries. Las tarjetas tienen un ancho fijo de 420 px, por lo que conviene verificar su visualización en pantallas menores a ese ancho más rellenos.
