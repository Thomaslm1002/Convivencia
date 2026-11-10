<?php
/**
 * logout.php
 * Cierra la sesión del usuario y lo redirige a la página de inicio.
 *
 * Pasos del archivo:
 *   1. Iniciar la sesión
 *   2. Vaciar los datos de sesión
 *   3. Eliminar la cookie de sesión
 *   4. Destruir la sesión
 *   5. Redirigir a index.php
 */

/*  1. INICIAR LA SESIÓN ==========
   Reanuda la sesión actual; es necesario antes de poder modificarla
   o destruirla. */
session_start();

/*  2. VACIAR LOS DATOS DE SESIÓN 
   Borra todas las variables guardadas en $_SESSION (usuario, rol, etc.). */
$_SESSION = [];

/*  3. ELIMINAR LA COOKIE DE SESIÓN  */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),      // Nombre de la cookie de sesión (por defecto PHPSESSID)
        '',                  // Valor vacío
        time() - 42000,      // Fecha de expiración ya vencida
        $params["path"],     // Ruta de la cookie
        $params["domain"],   // Dominio de la cookie
        $params["secure"],   // Solo se envía por HTTPS si es true
        $params["httponly"]  // Inaccesible desde JavaScript si es true
    );
}

/*  4. DESTRUIR LA SESIÓN  */
session_destroy();

/*  5. REDIRIGIR  */
header("Location: index.php");
exit();