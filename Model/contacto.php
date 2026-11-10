<?php
/**
 * Contacto.php
 * Modelo encargado de representar la información de los mensajes enviados
 * mediante el formulario de contacto de ManualitOnline.
 *
 * @Autor: Thomas Lopera Muñoz
 * @Fecha: 24/09/2026
 * @Descripción: Clase modelo de la tabla 'Contacto' de la base de datos.
 *
 * Atributos de la clase:
 * - $id: identificador único del mensaje de contacto.
 * - $nombre: nombre de la persona que envía el mensaje.
 * - $correo: dirección de correo electrónico de contacto.
 * - $telefono: número telefónico de la persona.
 * - $asunto: tema principal del mensaje.
 * - $mensaje: contenido del mensaje enviado.
 *
 * Funciones principales:
 * - Inicializar los atributos mediante el constructor.
 * - Consultar los valores mediante los métodos getters.
 * - Modificar los valores mediante los métodos setters.
 *
 * Secciones del archivo:
 * 1. Declaración de la clase y atributos.
 * 2. Constructor de la clase.
 * 3. Métodos getters.
 * 4. Métodos setters.
 */


/* 1. DECLARACIÓN DE LA CLASE Y ATRIBUTOS
 * La clase Contacto representa los datos de un mensaje enviado por una
 * persona a través del formulario de contacto.
 * Los atributos son privados para controlar su acceso desde otras clases
 * mediante los métodos públicos correspondientes.
 */
class Contacto {

    // Identificador único del mensaje de contacto.
    private $id;

    // Nombre de la persona que envía el mensaje.
    private $nombre;

    // Correo electrónico de la persona que envía el mensaje.
    private $correo;

    // Número telefónico de contacto.
    private $telefono;

    // Asunto o tema principal del mensaje.
    private $asunto;

    // Contenido del mensaje enviado.


    /* 2. CONSTRUCTOR DE LA CLASE
     * __construct() se ejecuta automáticamente al crear un objeto Contacto.
     * Recibe los datos del mensaje y los asigna a sus respectivos atributos.
     *
     * Parámetros:
     * - $id: identificador del mensaje.
     * - $nombre: nombre de la persona.
     * - $correo: correo electrónico de contacto.
     * - $telefono: número telefónico.
     * - $asunto: asunto del mensaje.
     * - $mensaje: contenido del mensaje.
     */
    private $mensaje;

    public function __construct($id, $nombre, $correo, $telefono, $asunto, $mensaje) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
    }


    /* 3. MÉTODOS GETTERS
     * Los getters permiten consultar los valores de los atributos privados
     * desde otras clases sin acceder directamente a ellos.
     */

    // Retorna el identificador del mensaje.
    public function getId() {
        return $this->id;
    }

    // Retorna el nombre de la persona que envía el mensaje.
    public function getNombre() {
        return $this->nombre;
    }

    // Retorna el correo electrónico de contacto.
    public function getCorreo() {
        return $this->correo;
    }

    // Retorna el número telefónico de contacto.
    public function getTelefono() {
        return $this->telefono;
    }

    // Retorna el asunto del mensaje.
    public function getAsunto() {
        return $this->asunto;
    }

    // Retorna el contenido del mensaje.
    public function getMensaje() {
        return $this->mensaje;
    }


    /* 4. MÉTODOS SETTERS
     * Los setters permiten asignar nuevos valores a los atributos privados
     * mediante métodos públicos.
     */

    // Asigna un identificador al mensaje de contacto.
    public function setId($id) {
        $this->id = $id;
    }

    // Actualiza el nombre de la persona.
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Actualiza el correo electrónico de contacto.
    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    // Actualiza el número telefónico de contacto.
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    // Actualiza el asunto del mensaje.
    public function setAsunto($asunto) {
        $this->asunto = $asunto;
    }

    // Actualiza el contenido del mensaje.
    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

} // Fin de la clase Contacto

?>