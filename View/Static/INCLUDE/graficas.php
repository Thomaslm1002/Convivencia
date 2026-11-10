<?php
// Incluye el modelo encargado de trabajar con las sugerencias.
require_once "../Model/contacto.php";
// Incluye la clase encargada de establecer la conexión con la base de datos.
require_once __DIR__ . '/../../../Controler/conexionbd.php';
// Incluye el controlador de las sugerencias.
require_once "../Controler/contactoctrl.php";
// Incluye el controlador encargado de los usuarios registrados.
require_once __DIR__ . '/../../../Controler/registrarctrl.php';
// Incluye el modelo de los usuarios registrados.
require_once "../Model/registrar.php";
// Define la tabla y la columna utilizada para consultar los usuarios.
$tablaUsuarios = 'registrar';
$colFechaUsuarios = 'fecha_registro';
// Define la tabla y la columna utilizada para consultar las sugerencias.
$tablaSugerencias = 'contacto';
$colFechaSugerencias = 'fecha';
// Define la cantidad de meses que se mostrarán en las estadísticas.
$mesesAMostrar = 6;
/**
 * Cuenta los registros de una tabla y los agrupa por mes.
 */
function contarPorMes( PDO $conexion, string $tabla,string $columna, int $meses):
 array {
    // Crea una lista con todos los meses del período y establece su valor inicial en 0.
    $resultado = [];
    for ($i = $meses - 1; $i >= 0; $i--) {
        $resultado[
            date('Y-m', strtotime("first day of -$i month"))
        ] = 0;
    }
    // Consulta la cantidad de registros existentes para cada mes.
    $sql = "SELECT 
                DATE_FORMAT(`$columna`, '%Y-%m') AS mes,
                COUNT(*) AS total
            FROM `$tabla`
            WHERE `$columna` >= DATE_FORMAT(
                DATE_SUB(CURDATE(), INTERVAL " . ($meses - 1) . " MONTH),
                '%Y-%m-01'
            )
            GROUP BY mes
            ORDER BY mes";
    // Ejecuta la consulta utilizando la conexión PDO.
    $consulta = $conexion->query($sql);
    // Comprueba si la consulta se ejecutó correctamente.
    if ($consulta) {
        // Recorre los resultados obtenidos de la base de datos.
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            // Guarda la cantidad de registros correspondiente a cada mes.
            if (isset($resultado[$fila['mes']])) {
                $resultado[$fila['mes']] = (int) $fila['total'];
            }
        }
    }
    // Devuelve los registros agrupados por mes.
    return $resultado;
}   
/**
 * Convierte una fecha en formato AAAA-MM
 * en una etiqueta corta para mostrar en las gráficas.
 * Ejemplo: Mar 2026
 */
function etiquetaMes(string $anioMes): string
{
    // Define los nombres abreviados de los meses.
    $nombres = [
        '',
        'Ene',
        'Feb',
        'Mar',
        'Abr',
        'May',
        'Jun',
        'Jul',
        'Ago',
        'Sep',
        'Oct',
        'Nov',
        'Dic'
    ];
    // Separa el año y el número del mes.
    [$anio, $mes] = explode('-', $anioMes);
    // Devuelve el mes abreviado acompañado del año.
    return $nombres[(int)$mes] . ' ' . $anio;
}
// Obtiene la conexión PDO con la base de datos.
$getConn = ConexionBD::getConn();
// Obtiene la cantidad de usuarios registrados por cada mes.
$usuariosPorMes = contarPorMes( $getConn, $tablaUsuarios, $colFechaUsuarios, $mesesAMostrar);
// Obtiene la cantidad de sugerencias recibidas por cada mes.
$sugerenciasPorMes = contarPorMes($getConn, $tablaSugerencias,$colFechaSugerencias, $mesesAMostrar);
// Convierte las fechas de los meses en etiquetas para las gráficas.
$etiquetas = array_map(
    'etiquetaMes',
    array_keys($usuariosPorMes)
);
// Obtiene únicamente los valores correspondientes a los usuarios.
$datosUsuarios = array_values($usuariosPorMes);
// Obtiene únicamente los valores correspondientes a las sugerencias.
$datosSugerencias = array_values($sugerenciasPorMes);

?>

<!-- Sección que contiene las estadísticas de usuarios y sugerencias -->
<section
    class="graficas-seccion"
    aria-label="Estadísticas de usuarios y sugerencias">
    <!-- Muestra los totales acumulados durante el período seleccionado -->
    <div class="graficas-resumen">
        <!-- Total de usuarios registrados -->
        <div class="grafica-total">
            <div class="numero">
                <?php echo array_sum($datosUsuarios); ?>
            </div>
            <div class="texto">
                Usuarios nuevos (<?php echo $mesesAMostrar; ?> meses)
            </div>
        </div>
        <!-- Total de sugerencias recibidas -->
        <div class="grafica-total">
            <div class="numero">
                <?php echo array_sum($datosSugerencias); ?>
            </div>
            <div class="texto">
                Sugerencias (<?php echo $mesesAMostrar; ?> meses)
            </div>
        </div>
    </div>
    <!-- Contenedor de las gráficas estadísticas -->
    <div class="graficas-grid">
        <!-- Gráfica de usuarios registrados -->
        <div class="grafica-card">
            <h3>Usuarios nuevos por mes</h3>
            <!-- Lienzo donde se representa la gráfica mediante JavaScript -->
            <div class="grafica-lienzo">
                <canvas id="graficaUsuarios"></canvas>
            </div>
        </div>
        <!-- Gráfica de sugerencias recibidas -->
        <div class="grafica-card">
            <h3>Sugerencias recibidas por mes</h3>
            <!-- Lienzo donde se representa la gráfica mediante JavaScript -->
            <div class="grafica-lienzo">
                <canvas id="graficaSugerencias"></canvas>
            </div>
        </div>
    </div>    
</section>
<!-- Convierte los datos obtenidos por PHP en variables disponibles para JavaScript -->
<script>
    const etiquetas = <?php echo json_encode($etiquetas, JSON_UNESCAPED_UNICODE); ?>;
    const datosUsuarios = <?php echo json_encode($datosUsuarios); ?>;
    const datosSugerencias = <?php echo json_encode($datosSugerencias); ?>;
</script>
