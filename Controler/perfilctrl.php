<?php
/**
 * perfilctrl.php
 * Controlador de la página "Mi perfil" (View/perfil.php). Recibe por POST los
 * dos formularios de esa página, valida los datos, los guarda mediante el
 * modelo Perfil y vuelve a la vista dejando un mensaje en la sesión.
 *
 * Acciones que acepta (campo oculto "accion" del formulario):
 *   - actualizar   cambia el nombre y el correo de la persona con sesión
 *   - clave        cambia la contraseña (pide la actual, la nueva y su confirmación)
 *
 * Métodos del modelo Perfil que usa:
 *   - obtenerPerfil($correo, $tipo)
 *       devuelve los datos de la cuenta (incluye 'id', 'nombre' y 'correo') o falso si no existe
 *   - actualizarDatos($id, $correoActual, $tipo, $nombre, $correoNuevo)
 *       devuelve 'correo_existente' si el correo nuevo ya pertenece a otra cuenta
 *   - cambiarClave($id, $correo, $tipo, $claveActual, $claveNueva)
 *       devuelve verdadero si la clave actual era correcta y se cambió
 *
 * Mensaje de resultado: se guarda en $_SESSION['mensaje'] con la forma
 * ['tipo' => 'ok' | 'error', 'texto' => '...'] y la vista lo muestra una sola vez.
 *
 * Secciones del archivo:
 *   1. Sesión, dependencias y conexión
 *   2. Constante y función para volver a la vista
 *   3. Validaciones previas (sesión iniciada y método POST)
 *   4. Carga del perfil actual
 *   5. Procesamiento de la acción
 */

/* 1. SESIÓN, DEPENDENCIAS Y CONEXIÓN
   require_once evita cargar dos veces un mismo archivo (los includes circulares
   son una causa típica de agotar la memoria). */
session_start();

require_once __DIR__ . '/conexionbd.php';
require_once __DIR__ . '/../Model/perfil.php';

// Conexión activa a la base de datos.
$conexion = ConexionBD::getConn();


/* 2. CONSTANTE Y FUNCIÓN PARA VOLVER A LA VISTA
   VISTA_PERFIL es la ruta de la página de perfil, relativa a este archivo.
   volver() guarda el mensaje en la sesión, redirige a la vista y termina la
   ejecución, por lo que ninguna línea después de llamarla se ejecuta.
   $tipo es 'ok' (éxito) o 'error'. */
const VISTA_PERFIL = '../View/perfil.php';

function volver(string $tipo, string $texto): void
{
    $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
    header('Location: ' . VISTA_PERFIL);
    exit;
}


/* 3. VALIDACIONES PREVIAS */

// Debe haber sesión iniciada (correo y tipo de cuenta guardados en la sesión).
if (empty($_SESSION['correo']) || empty($_SESSION['tipo'])) {
    header('Location: ../index.php');
    exit;
}

// Solo se acepta POST: si alguien abre este archivo escribiendo la URL
// (GET), se le devuelve a la página de perfil.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . VISTA_PERFIL);
    exit;
}


/* 4. CARGA DEL PERFIL ACTUAL
   Se busca la cuenta con el correo y el tipo guardados en la sesión, y de ahí
   se toma el id. El id nunca viene del formulario, así que una persona solo
   puede modificar su propia cuenta. Si la cuenta ya no existe, se cierra la
   sesión. */
$perfil       = new Perfil($conexion);
$correoSesion = $_SESSION['correo'];
$tipoSesion   = $_SESSION['tipo'];

$datos = $perfil->obtenerPerfil($correoSesion, $tipoSesion);
if (!$datos) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$id     = (int) $datos['id'];
$accion = $_POST['accion'] ?? '';


/* 5. PROCESAMIENTO DE LA ACCIÓN
   Según el valor de "accion" se ejecuta una de las dos opciones. Cualquier
   error de base de datos (PDOException) se registra con error_log() y a la
   persona solo se le muestra un mensaje genérico, para no revelar detalles
   internos. */
try {
    switch ($accion) {

        // Actualizar nombre y correo
        case 'actualizar':
            $nombre      = trim($_POST['nombre'] ?? '');
            $correoNuevo = trim($_POST['correo'] ?? '');

            // El nombre es obligatorio y de máximo 100 caracteres.
            if ($nombre === '' || mb_strlen($nombre) > 100) {
                volver('error', 'El nombre es obligatorio (máximo 100 caracteres).');
            }
            // El correo debe tener un formato válido.
            if (!filter_var($correoNuevo, FILTER_VALIDATE_EMAIL)) {
                volver('error', 'El correo no es válido.');
            }

            $resultado = $perfil->actualizarDatos(
                $id, $correoSesion, $tipoSesion, $nombre, $correoNuevo
            );

            // El correo nuevo ya lo usa otra cuenta.
            if ($resultado === 'correo_existente') {
                volver('error', 'Ese correo ya pertenece a otra cuenta.');
            }

            // Se actualiza la sesión para que siga apuntando a la cuenta
            // (el correo es lo que la identifica). El nombre solo se
            // actualiza si la sesión ya tenía la clave 'nombre'.
            $_SESSION['correo'] = $correoNuevo;
            if (isset($_SESSION['nombre'])) {
                $_SESSION['nombre'] = $nombre;
            }
            volver('ok', 'Datos actualizados correctamente.');
            break;

        // Cambiar la contraseña
        case 'clave':
            $actual    = $_POST['clave_actual'] ?? '';
            $nueva     = $_POST['clave_nueva'] ?? '';
            $confirmar = $_POST['clave_confirmar'] ?? '';

            // La clave nueva debe tener al menos 8 caracteres.
            if (strlen($nueva) < 8) {
                volver('error', 'La nueva clave debe tener al menos 8 caracteres.');
            }
            // La confirmación debe ser igual a la clave nueva.
            if ($nueva !== $confirmar) {
                volver('error', 'La confirmación no coincide con la nueva clave.');
            }

            // El modelo comprueba la clave actual antes de cambiarla.
            if ($perfil->cambiarClave($id, $correoSesion, $tipoSesion, $actual, $nueva)) {
                volver('ok', 'Clave cambiada correctamente.');
            }
            volver('error', 'La clave actual es incorrecta.');
            break;

        // Cualquier otro valor de "accion"
        default:
            volver('error', 'Acción no válida.');
    }
} catch (PDOException $e) {
    error_log('Error en perfil: ' . $e->getMessage());
    volver('error', 'Ocurrió un error al procesar la solicitud.');
}