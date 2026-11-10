# Documentación técnica de `css/usuarios.css`

## Propósito

Estiliza la tabla de administración de usuarios y sus acciones de editar/eliminar.

## Selectores

| Selector | Función |
|---|---|
| `table` | Tabla al 100% de ancho, fondo blanco, bordes colapsados, margen superior y sombra. |
| `th` | Cabecera azul con texto blanco y relleno. |
| `td` | Celdas centradas con relleno y divisor inferior. |
| `.btn` | Base de enlaces/botones de acción: relleno, bordes redondeados, texto blanco y sin subrayado. |
| `.editar` | Variante verde para editar. |
| `.eliminar` | Variante roja para eliminar. |

## Uso previsto

Las variantes `.editar` y `.eliminar` se aplican junto con `.btn`, por ejemplo: `<a class="btn editar">Editar</a>`.
