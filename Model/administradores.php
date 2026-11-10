<?php
/**
 * Administradores.php
 * Modelo encargado de representar los datos de los administradores
 * registrados en la base de datos.
 *
 * @Autor: Thomas Lopera Muñoz
 * @Fecha: 24/09/2026
 * @Descripción: Clase modelo de la tabla 'Administradores' de la base de datos.
 *
 * Atributos de la clase:
 * - $id: identificador único del administrador.
 * - $correo: dirección de correo electrónico del administrador.
 * - $nombre: nombre del administrador.
 *
 * Funciones principales:
 * - Inicializar los atributos mediante el constructor.
 * - Obtener los valores de los atributos mediante getters.
 * - Modificar los valores de los atributos mediante setters.
 *
 * Secciones del archivo:
 * 1. Declaración de la clase y atributos.
 * 2. Constructor de la clase.
 * 3. Métodos getters.
 * 4. Métodos setters.
 */


/* 1. DECLARACIÓN DE LA CLASE Y ATRIBUTOS
 * La clase Administradores representa la información de un administrador.
 * Sus atributos son privados para controlar el acceso a los datos mediante
 * los métodos públicos definidos en la clase.
 */
class Administradores {

    // Identificador único del administrador.
    private $id;

    // Correo electrónico asociado a la cuenta del administrador.
    private $correo;

    // Nombre completo del administrador.


    /* 2. CONSTRUCTOR DE LA CLASE
     * __construct() se ejecuta automáticamente al crear un objeto
     * Administradores y asigna los valores iniciales a sus atributos.
     *
     * Parámetros:
     * - $id: identificador del administrador.
     * - $correo: correo electrónico del administrador.
     * - $nombre: nombre del administrador.
     */
    private $nombre;

    public function __construct($id, $correo, $nombre) {
        $this->id = $id;
        $this->correo = $correo;
        $this->nombre = $nombre;
    }


    /* 3. MÉTODOS GETTERS
     * Los getters permiten consultar los valores de los atributos privados
     * desde otras clases sin acceder directamente a ellos.
     */

    // Retorna el identificador del administrador.
    public function getId() {
        return $this->id;
    }

    // Retorna el correo electrónico del administrador.
    public function getCorreo() {
        return $this->correo;
    }

    // Retorna el nombre del administrador.
    public function getNombre() {
        return $this->nombre;
    }


    /* 4. MÉTODOS SETTERS
     * Los setters permiten modificar los valores de los atributos privados
     * mediante métodos públicos.
     */

    // Asigna un nuevo identificador al administrador.
    public function setId($id) {
        $this->id = $id;
    }

    // Actualiza el correo electrónico del administrador.
    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    // Actualiza el nombre del administrador.
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

} // Fin de la clase Administradores

?>
