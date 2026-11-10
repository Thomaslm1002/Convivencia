# Documentación técnica de `css/registrar.css`

## Propósito

Da formato a la pantalla de registro y su formulario, siguiendo la estética de tarjeta translúcida sobre degradado azul.

## Componentes y selectores

| Grupo de selectores | Función |
|---|---|
| `@import`, `*`, `body` | Carga Poppins, normaliza elementos y centra el formulario en pantalla completa. |
| `.register-container`, `.register-container h2`, `.register-subtitle` | Tarjeta, título y descripción del registro. |
| `.form-group`, `.form-group label` | Espaciado y estilo de cada campo. |
| `.form-group input`, `.form-group select`, `::placeholder`, `option`, `:focus` | Entradas y listas desplegables, incluidos estado de foco y texto de ayuda. |
| `.form-row`, `.form-row .form-group` | Coloca dos o más grupos de campos en una misma fila flexible. |
| `.admin-key-group` | Campo administrativo inicialmente oculto; debe mostrarse mediante JavaScript cuando corresponda. |
| `.error-message` | Mensajes de validación en rojo claro. |
| `.btn`, `.btn:hover` | Botón de envío y su respuesta visual. |
| `.divider`, `::before`, `::after`, `span` | Separador horizontal con texto central. |
| `.login-link`, `.login-link a`, `.login-link a:hover` | Enlace de retorno al inicio de sesión. |

## Diseño adaptable

En `@media (max-width: 500px)`, el contenedor usa todo el ancho disponible, reduce el relleno y `.form-row` cambia a columna.
