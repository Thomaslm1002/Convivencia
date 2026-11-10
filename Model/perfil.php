
<?php
/**
 * Perfil.php
 * Modelo encargado de consultar y actualizar la información del perfil
 * de los usuarios y administradores de ManualitOnline.
 *
 * @Autor: Thomas Lopera Muñoz
 * @Fecha: 24/09/2026
 * @Descripción: Clase modelo para gestionar los datos personales y las
 * claves de acceso de las cuentas registradas en la base de datos.
 *
 * Tablas utilizadas:
 * - administradores: almacena la información de los administradores.
 * - registrar: almacena la información de los usuarios registrados.
 *
 * Funciones principales:
 * - Determinar la tabla correspondiente al tipo de cuenta.
 * - Obtener los datos del perfil sin recuperar la clave.
 * - Actualizar el nombre y el correo electrónico.
 * - Comprobar si un correo nuevo pertenece a otra cuenta.
 * - Verificar la clave actual y actualizarla de forma segura.
 *
 * Secciones del archivo:
 * 1. Declaración de la clase y lista de tablas permitidas.
 * 2. Constructor y conexión a la base de datos.
 * 3. Selección de la tabla según el tipo de cuenta.
 * 4. Consulta de los datos del perfil.
 * 5. Actualización del nombre y el correo.
 * 6. Cambio de la clave de acceso.
 */


/* 1. DECLARACIÓN DE LA CLASE Y LISTA DE TABLAS
 * La clase Perfil centraliza las operaciones relacionadas con la información
 * personal de las cuentas de ManualitOnline.
 *
 * La constante TABLAS define una lista de nombres de tablas permitidos.
 * Esto evita utilizar directamente nombres de tablas proporcionados por
 * el usuario dentro de las consultas SQL.
 */
class Perfil
{
    // Conexión PDO utilizada para ejecutar las consultas a la base de datos.
    private PDO $conexion;

    // Lista de tablas autorizadas según el tipo de cuenta.
    private const TABLAS = [
        'administrador' => 'administradores',
        'usuario'       => 'registrar',
    ];


    /* 2. CONSTRUCTOR Y CONEXIÓN A LA BASE DE DATOS
     * El constructor recibe una conexión PDO existente y la guarda
     * en el atributo privado $conexion para utilizarla en los métodos
     * de consulta y actualización.
     *
     * Parámetro:
     * - $conexion: objeto PDO que permite acceder a la base de datos.
     */
    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }


    /* 3. SELECCIÓN DE LA TABLA SEGÚN EL TIPO DE CUENTA
     * obtenerTabla() determina qué tabla debe utilizarse según el tipo
     * de cuenta recibido.
     *
     * Parámetro:
     * - $tipo: tipo de cuenta, administrador o usuario.
     *
     * Retorno:
     * - Nombre de la tabla administradores si el tipo es administrador.
     * - Nombre de la tabla registrar en los demás casos.
     */
    private function obtenerTabla(string $tipo): string
    {
        // Normaliza el tipo de cuenta para comparar sin distinguir mayúsculas.
        return strtolower($tipo) === 'administrador'
            ? self::TABLAS['administrador']
            : self::TABLAS['usuario'];
    }


    /* 4. CONSULTA DE LOS DATOS DEL PERFIL
     * obtenerPerfil() busca una cuenta utilizando su correo electrónico
     * y su tipo de cuenta para determinar la tabla correspondiente.
     *
     * Parámetros:
     * - $correo: correo electrónico de la cuenta.
     * - $tipo: tipo de cuenta que se desea consultar.
     *
     * Retorno:
     * - Arreglo asociativo con id, nombre y correo si la cuenta existe.
     * - false si no se encuentra ningún registro.
     *
     * Por seguridad, la consulta no recupera el campo de la clave.
     */
    public function obtenerPerfil(string $correo, string $tipo)
    {
        // Obtiene el nombre de la tabla autorizada para la cuenta.
        $tabla = $this->obtenerTabla($tipo);

        // Prepara la consulta para buscar la cuenta por correo.
        $stmt = $this->conexion->prepare(
            "SELECT id, nombre, correo FROM $tabla
             WHERE correo = :correo LIMIT 1"
        );

        // Asigna el correo al parámetro de la consulta y la ejecuta.
        $stmt->execute([':correo' => $correo]);

        // Recupera los datos encontrados como un arreglo asociativo.
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        // Libera el cursor de la consulta.
        $stmt->closeCursor();

        return $fila;
    }


    /* 5. ACTUALIZACIÓN DEL NOMBRE Y EL CORREO
     * actualizarDatos() modifica el nombre y el correo electrónico de una
     * cuenta existente. Antes de actualizar, comprueba que el nuevo correo
     * no esté asociado a otro registro de la misma tabla.
     *
     * Parámetros:
     * - $id: identificador de la cuenta que se actualizará.
     * - $correoActual: correo que tiene actualmente la cuenta.
     * - $tipo: tipo de cuenta, administrador o usuario.
     * - $nombre: nuevo nombre de la cuenta.
     * - $correoNuevo: nuevo correo electrónico.
     *
     * Retorno:
     * - 'ok': se modificaron los datos.
     * - 'correo_existente': el correo nuevo pertenece a otra cuenta.
     * - 'sin_cambios': no se modificaron filas.
     */
    public function actualizarDatos(
        int $id,
        string $correoActual,
        string $tipo,
        string $nombre,
        string $correoNuevo
    ): string {
        // Determina la tabla correspondiente al tipo de cuenta.
        $tabla = $this->obtenerTabla($tipo);

        // Comprueba que el correo nuevo no pertenezca a otro registro.
        // La condición id != :id excluye la propia cuenta de la búsqueda.
        $stmt = $this->conexion->prepare(
            "SELECT id FROM $tabla
             WHERE correo = :nuevo AND id != :id LIMIT 1"
        );

        // Ejecuta la comprobación con los valores recibidos.
        $stmt->execute([
            ':nuevo' => $correoNuevo,
            ':id'    => $id
        ]);

        // Recupera el resultado de la búsqueda.
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);

        // Libera el cursor antes de ejecutar la siguiente consulta.
        $stmt->closeCursor();

        // Impide actualizar los datos si el correo ya pertenece a otra cuenta.
        if ($existe) {
            return 'correo_existente';
        }

        // Prepara la actualización del nombre y el correo.
        // También verifica el correo actual para identificar la cuenta.
        $stmt = $this->conexion->prepare(
            "UPDATE $tabla
             SET nombre = :nombre, correo = :nuevo
             WHERE id = :id AND correo = :actual"
        );

        // Asigna los valores y ejecuta la actualización.
        $stmt->execute([
            ':nombre' => $nombre,
            ':nuevo'  => $correoNuevo,
            ':id'     => $id,
            ':actual' => $correoActual,
        ]);

        // Indica si se modificó alguna fila de la tabla.
        return $stmt->rowCount() > 0 ? 'ok' : 'sin_cambios';
    }


    /* 6. CAMBIO DE LA CLAVE DE ACCESO
     * cambiarClave() verifica la clave actual de la cuenta y, si coincide
     * con el hash almacenado, genera un nuevo hash y actualiza la clave.
     *
     * Parámetros:
     * - $id: identificador de la cuenta.
     * - $correo: correo electrónico asociado a la cuenta.
     * - $tipo: tipo de cuenta que se actualizará.
     * - $claveActual: clave que la persona utiliza actualmente.
     * - $claveNueva: nueva clave que desea establecer.
     *
     * Retorno:
     * - true si la consulta de actualización se ejecuta correctamente.
     * - false si la cuenta no existe o la clave actual es incorrecta.
     *
     * La clave nueva se almacena mediante password_hash(), evitando guardar
     * contraseñas en texto plano.
     */
    public function cambiarClave(
        int $id,
        string $correo,
        string $tipo,
        string $claveActual,
        string $claveNueva
    ): bool {
        // Determina la tabla correspondiente a la cuenta.
        $tabla = $this->obtenerTabla($tipo);

        // Busca la clave almacenada para el identificador y el correo indicados.
        $stmt = $this->conexion->prepare(
            "SELECT clave FROM $tabla
             WHERE id = :id AND correo = :correo LIMIT 1"
        );

        // Ejecuta la consulta con los datos de la cuenta.
        $stmt->execute([
            ':id'     => $id,
            ':correo' => $correo
        ]);

        // Recupera el hash de la clave si la cuenta existe.
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Libera el cursor de la consulta.
        $stmt->closeCursor();

        // Comprueba que la cuenta exista y que la clave actual sea correcta.
        if (!$usuario || !password_verify($claveActual, $usuario['clave'])) {
            return false;
        }

        // Genera el hash de la nueva clave antes de almacenarla.
        $hash = password_hash($claveNueva, PASSWORD_DEFAULT);

        // Prepara la actualización de la clave de la cuenta.
        $stmt = $this->conexion->prepare(
            "UPDATE $tabla
             SET clave = :clave
             WHERE id = :id AND correo = :correo"
        );

        // Ejecuta la actualización y devuelve el resultado de la operación.
        return $stmt->execute([
            ':clave'  => $hash,
            ':id'     => $id,
            ':correo' => $correo,
        ]);
    }

} // Fin de la clase Perfil

?>
