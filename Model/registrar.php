<?php
/**
 * Registrar.php
 * Modelo encargado de representar los datos de las cuentas registradas
 * en la plataforma ManualitOnline.
 *
 * @Autor: Thomas Lopera Muñoz
 * @Fecha: 24/09/2026
 * @Descripción: Clase modelo de la tabla 'Registrar' de la base de datos.
 *
 * Atributos de la clase:
 * - $id: identificador único del registro.
 * - $nombre: nombre de la persona registrada.
 * - $correo: dirección de correo electrónico de la cuenta.
 * - $clave: clave de acceso de la cuenta.
 * - $confirmarClave: confirmación de la clave introducida.
 * - $tipoCuenta: tipo de cuenta, como usuario o administrador.
 *
 * Funciones principales:
 * - Inicializar los atributos mediante el constructor.
 * - Consultar los valores de los atributos mediante getters.
 * - Modificar los valores de los atributos mediante setters.
 *
 * Secciones del archivo:
 * 1. Declaración de la clase y atributos.
 * 2. Constructor de la clase.
 * 3. Métodos getters.
 * 4. Métodos setters.
 */


/* 1. DECLARACIÓN DE LA CLASE Y ATRIBUTOS
 * La clase Registrar representa los datos de una cuenta de ManualitOnline.
 * Sus atributos son privados para controlar el acceso a la información
 * mediante los métodos públicos definidos dentro de la clase.
 */
class Registrar {

    // Identificador único de la cuenta registrada.
    private $id;

    // Nombre de la persona titular de la cuenta.
    private $nombre;

    // Correo electrónico utilizado para identificar la cuenta.
    private $correo;

    // Clave de acceso proporcionada durante el registro.
    private $clave;

    // Confirmación de la clave introducida en el formulario.
    private $confirmarClave;

    // Tipo de cuenta asociado al registro.
    private $tipoCuenta;


    /* 2. CONSTRUCTOR DE LA CLASE
     * __construct() se ejecuta automáticamente al crear un objeto Registrar.
     * Recibe los datos de la cuenta y los asigna a sus respectivos atributos.
     *
     * Parámetros:
     * - $id: identificador de la cuenta.
     * - $nombre: nombre de la persona registrada.
     * - $correo: correo electrónico de la cuenta.
     * - $clave: clave de acceso.
     * - $confirmarClave: confirmación de la clave.
     * - $tipoCuenta: tipo de cuenta del registro.
     */
    public function __construct($id, $nombre, $correo, $clave, $confirmarClave, $tipoCuenta) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->confirmarClave = $confirmarClave;
        $this->tipoCuenta = $tipoCuenta;
    }


    /* 3. MÉTODOS GETTERS
     * Los getters permiten consultar los valores de los atributos privados
     * desde otras clases sin acceder directamente a ellos.
     */

    // Retorna el identificador de la cuenta.
    public function getId() {
        return $this->id;
    }

    // Retorna el nombre de la persona registrada.
    public function getNombre() {
        return $this->nombre;
    }

    // Retorna el correo electrónico de la cuenta.
    public function getCorreo() {
        return $this->correo;
    }

    // Retorna la clave de acceso.
    public function getClave() {
        return $this->clave;
    }

    // Retorna la confirmación de la clave.
    public function getConfirmarClave() {
        return $this->confirmarClave;
    }

    // Retorna el tipo de cuenta.
    public function getTipoCuenta() {
        return $this->tipoCuenta;
    }


    /* 4. MÉTODOS SETTERS
     * Los setters permiten asignar nuevos valores a los atributos privados
     * mediante métodos públicos, facilitando la modificación de los datos
     * de una cuenta desde otras clases.
     */

    // Asigna o actualiza el identificador de la cuenta.
    public function setId($id) {
        $this->id = $id;
    }

    // Actualiza el nombre de la persona registrada.
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Actualiza el correo electrónico de la cuenta.
    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    // Asigna o actualiza la clave de acceso.
    public function setClave($clave) {
        $this->clave = $clave;
    }

    // Actualiza la confirmación de la clave.
    public function setConfirmarClave($confirmarClave) {
        $this->confirmarClave = $confirmarClave;
    }

    // Actualiza el tipo de cuenta.
    public function setTipoCuenta($tipoCuenta) {
        $this->tipoCuenta = $tipoCuenta;
    }

} // Fin de la clase Registrar

?>
