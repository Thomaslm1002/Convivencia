<?php
/**
 * eliminar_usuarios.php
 * Elimina un usuario de la base de datos y vuelve al listado.
 * Se usa con el id en la URL: eliminar_usuarios.php?id=5
 *
 * Pasos del archivo:
 *   1. Cargar dependencias
 *   2. Eliminar el usuario, si se recibió un id
 *   3. Redirigir al listado de usuarios
 */

/*  1. DEPENDENCIAS  */
session_start();

//  Control de acceso: solo pueden entrar los administradores 
// Si el usuario no tiene sesión o su tipo no es "administrador", se le
// redirige a la página de inicio de sesión y se detiene la ejecución.
if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header("Location: Iniciar.php");
    exit();
}

require_once "../Model/registrar.php";
require_once "../Controler/registrarctrl.php";

/*  2. ELIMINAR EL CONTACTO  */
if (isset($_GET['id'])) {

    // Obtiene el ID del usuario que se desea eliminar
    $id = (int) $_GET['id'];

    // Elimina el registro del usuario
    (new Registrarctrl())->eliminar($id);

    // Redirige a la página de usuarios
    header("Location: usuarios.php");
    exit();

} else {
    // Si no se recibió un ID válido, redirige a la página de usuarios
    header("Location: usuarios.php");
    exit();
}

?>