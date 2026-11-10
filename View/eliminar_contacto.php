<?php
/**
 * eliminar_contacto.php
 * Elimina un contacto (sugerencia) de la base de datos y vuelve al listado.
 * Se usa con el id en la URL: eliminar_contacto.php?id=5
 *
 * Pasos del archivo:
 *   1. Cargar dependencias
 *   2. Eliminar el contacto, si se recibió un id
 *   3. Redirigir al listado de sugerencias
 */

///  1. DEPENDENCIAS  */
// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

//  Control de acceso: solo pueden entrar los administradores 
// Si el usuario no tiene sesión o su tipo no es "administrador", se le
// redirige a la página de inicio de sesión y se detiene la ejecución.
if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header("Location: Iniciar.php");
    exit();
}
require_once "../Model/contacto.php";
require_once "../Controler/Contactoctrl.php";

/*  2. ELIMINAR EL CONTACTO  */
if (isset($_GET['id'])) {

    // Obtiene el ID del contacto que se desea eliminar
    $id = (int) $_GET['id'];

    // Elimina el registro del contacto
    (new Contactoctrl())->eliminar($id);
}

/*  3. REDIRIGIR  */
header("Location: sugerencias.php");
exit();