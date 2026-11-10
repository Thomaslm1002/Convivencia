
<?php
/**
 * Registrarctrl.php
 * Controlador encargado de gestionar las operaciones relacionadas con los
 * registros de usuarios de la tabla 'registrar' en la base de datos.
 *
 * @autor Thomas Lopera Muñoz
 * @fecha 24/09/2026
 *
 * Funciones principales:
 * - Listar los registros de usuarios.
 * - Insertar nuevos registros y proteger las claves mediante hash.
 * - Comprobar si un correo ya está registrado.
 * - Buscar registros por su identificador.
 * - Actualizar las claves y los datos de los usuarios.
 * - Eliminar registros.
 * - Verificar las credenciales de inicio de sesión.
 * - Contar el total de registros existentes.
 *
 * Dependencias:
 * - conexionbd.php: proporciona la conexión PDO a la base de datos.
 * - registrar.php: contiene el modelo Registrar y sus métodos getters.
 *
 * Secciones del archivo:
 * 1. Inclusión de dependencias.
 * 2. Declaración de la clase y conexión.
 * 3. Listado de registros.
 * 4. Inserción de registros.
 * 5. Verificación de correos.
 * 6. Búsqueda por identificador.
 * 7. Actualización de claves.
 * 8. Actualización de datos.
 * 9. Eliminación de registros.
 * 10. Verificación de credenciales.
 * 11. Conteo de registros.
 */

 /* 1. INCLUSIÓN DE DEPENDENCIAS
  * require_once evita cargar varias veces los archivos necesarios para
  * establecer la conexión y utilizar el modelo Registrar.
  */
require_once(__DIR__ . '/conexionbd.php');
require_once(__DIR__ . '/../model/registrar.php');


/* 2. DECLARACIÓN DE LA CLASE Y CONEXIÓN
 * Registrarctrl centraliza las operaciones de acceso a datos relacionadas
 * con los usuarios. La conexión se obtiene mediante ConexionBD.
 */
class Registrarctrl {

    // Objeto del modelo Registrar utilizado para representar los registros.
    private $registrarMdl;

    // Conexión PDO utilizada para ejecutar consultas SQL.
    private $conn;

    /**
     * Constructor de la clase.
     *
     * Obtiene la conexión activa a la base de datos mediante el método
     * estático getConn() de la clase ConexionBD.
     */
    public function __construct() {
        $this->conn = ConexionBD::getConn();
    }


    /* 3. LISTADO DE REGISTROS
     * listar() consulta los usuarios registrados y devuelve un arreglo
     * de objetos Registrar. No recupera las claves de la base de datos,
     * por lo que los atributos clave y confirmarClave se inicializan en null.
     *
     * Retorno:
     * - Arreglo de objetos Registrar si existen registros.
     * - Arreglo vacío si no hay usuarios registrados.
     */
    public function listar() {
        $registros = array();

        try {
            // Consulta únicamente los datos necesarios para el listado.
            $stmt = $this->conn->prepare(
                "SELECT id, Nombre, correo, TipoCuenta FROM registrar"
            );

            $stmt->execute();

            // Recupera los resultados como arreglos asociativos.
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convierte cada fila de la consulta en un objeto Registrar.
            if ($stmt->rowCount() > 0) {
                foreach ($resultSet as $reg) {
                    $this->registrarMdl = new Registrar(
                        $reg['id'],
                        $reg['Nombre'],
                        $reg['correo'],
                        null,
                        null,
                        $reg['TipoCuenta']
                    );

                    $registros[] = $this->registrarMdl;
                }
            }
        } catch (Exception $exc) {
            // Detiene la ejecución y muestra el error producido.
            die("Error: " . $exc->getMessage());
        }

        return $registros;
    } // Fin del método listar()


    /* 4. INSERCIÓN DE REGISTROS
     * insertar() recibe un objeto Registrar, comprueba que las claves
     * coincidan, protege la clave mediante password_hash() y guarda los
     * datos en la tabla registrar.
     *
     * Retorno:
     * - Identificador del nuevo registro si se inserta correctamente.
     * - 0 si las claves no coinciden.
     */
    public function insertar($registrar) {
        $insertado = 0;

        try {
            // Comprueba que la clave y su confirmación sean iguales.
            if ($registrar->getClave() !== $registrar->getConfirmarClave()) {
                return 0;
            }

            // Genera un hash seguro para no almacenar la clave en texto plano.
            $hash = password_hash(
                $registrar->getClave(),
                PASSWORD_DEFAULT
            );

            // Define la consulta parametrizada para insertar el registro.
            $stmt = "INSERT INTO registrar (Nombre, correo, Clave, TipoCuenta)
                     VALUES (?, ?, ?, ?)";

            // Organiza los valores en el mismo orden de los parámetros SQL.
            $reg = array(
                $registrar->getNombre(),
                $registrar->getCorreo(),
                $hash,
                $registrar->getTipoCuenta()
            );

            $st = $this->conn->prepare($stmt);

            // Ejecuta la inserción y obtiene el identificador generado.
            if ($st->execute($reg)) {
                $insertado = (int) $this->conn->lastInsertId();
            } else {
                // Muestra la información del error y detiene la ejecución.
                var_dump($st->errorInfo());
                exit;
            }
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $insertado;
    } // Fin del método insertar()


    /* 5. VERIFICACIÓN DE CORREOS
     * existeCorreo() comprueba si una dirección de correo ya está asociada
     * a un registro de la tabla registrar.
     *
     * Parámetro:
     * - $correo: dirección de correo que se desea comprobar.
     *
     * Retorno:
     * - true si el correo existe.
     * - false si no se encuentra registrado.
     */
    public function existeCorreo($correo) {
        $existe = false;

        try {
            // Busca el identificador de una cuenta con el correo indicado.
            $stmt = $this->conn->prepare(
                "SELECT id FROM registrar WHERE correo = ?"
            );

            $stmt->execute(array($correo));

            // Comprueba si la consulta encontró un registro.
            $existe = $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $existe;
    } // Fin del método existeCorreo()


    /* 6. BÚSQUEDA POR IDENTIFICADOR
     * buscarPorId() consulta un registro utilizando su identificador.
     * Los datos encontrados se convierten en un objeto Registrar.
     * Las claves no se recuperan por motivos de seguridad.
     *
     * Parámetro:
     * - $id: identificador del registro que se desea buscar.
     *
     * Retorno:
     * - Objeto Registrar si el registro existe.
     * - null si no se encuentra.
     */
    public function buscarPorId($id) {
        $registro = null;

        try {
            // Consulta los datos del registro correspondiente al identificador.
            $stmt = $this->conn->prepare(
                "SELECT id, Nombre, correo, TipoCuenta
                 FROM registrar WHERE id = ?"
            );

            $stmt->execute(array($id));

            // Recupera una única fila de resultados.
            $reg = $stmt->fetch(PDO::FETCH_ASSOC);

            // Construye el objeto únicamente si se encontró el registro.
            if ($reg) {
                $registro = new Registrar(
                    $reg['id'],
                    $reg['Nombre'],
                    $reg['correo'],
                    null,
                    null,
                    $reg['TipoCuenta']
                );
            }
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $registro;
    } // Fin del método buscarPorId()


    /* 7. ACTUALIZACIÓN DE CLAVES
     * actualizarClave() genera un nuevo hash para la clave recibida y
     * actualiza el campo Clave del registro identificado por su id.
     *
     * Parámetros:
     * - $id: identificador de la cuenta que se actualizará.
     * - $claveNueva: nueva clave que se almacenará como hash.
     *
     * Retorno:
     * - Resultado de execute(), que indica si la consulta se ejecutó
     *   correctamente.
     */
    public function actualizarClave($id, $claveNueva) {
        $actualizado = 0;

        try {
            // Protege la nueva clave antes de guardarla en la base de datos.
            $hash = password_hash($claveNueva, PASSWORD_DEFAULT);

            // Actualiza exclusivamente la clave del registro seleccionado.
            $stmt = "UPDATE registrar SET Clave = ? WHERE id = ?";

            $actualizado = $this->conn->prepare($stmt)->execute(
                array($hash, $id)
            );
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $actualizado;
    } // Fin del método actualizarClave()


    /* 8. ACTUALIZACIÓN DE DATOS
     * actualizar() modifica el nombre, el correo y el tipo de cuenta
     * de un usuario existente, utilizando su identificador para localizarlo.
     *
     * Parámetro:
     * - $registrar: objeto Registrar con los datos que se actualizarán.
     *
     * Retorno:
     * - Resultado de execute(), que indica si la consulta se ejecutó
     *   correctamente.
     */
    public function actualizar($registrar) {
        $actualizado = 0;

        try {
            // Define los campos que se modificarán en la tabla.
            $stmt = "UPDATE registrar
                     SET Nombre = ?, correo = ?, TipoCuenta = ?
                     WHERE id = ?";

            // Ejecuta la actualización con los datos del objeto recibido.
            $actualizado = $this->conn->prepare($stmt)->execute(
                array(
                    $registrar->getNombre(),
                    $registrar->getCorreo(),
                    $registrar->getTipoCuenta(),
                    $registrar->getId()
                )
            );
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $actualizado;
    } // Fin del método actualizar()


    /* 9. ELIMINACIÓN DE REGISTROS
     * eliminar() elimina de la tabla registrar el usuario cuyo identificador
     * coincide con el parámetro recibido.
     *
     * Parámetro:
     * - $idRegistro: identificador del registro que se desea eliminar.
     *
     * Retorno:
     * - Resultado de execute(), que indica si la consulta se ejecutó
     *   correctamente.
     */
    public function eliminar($idRegistro) {
        $eliminado = 0;

        try {
            // Prepara la consulta de eliminación por identificador.
            $stmt = $this->conn->prepare(
                "DELETE FROM registrar WHERE id = ?"
            );

            // Ejecuta la eliminación del registro seleccionado.
            $eliminado = $stmt->execute(array($idRegistro));
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $eliminado;
    } // Fin del método eliminar()


    /* 10. VERIFICACIÓN DE CREDENCIALES
     * verificar() busca una cuenta mediante el correo y comprueba la clave
     * introducida con el hash almacenado en la base de datos.
     *
     * Parámetros:
     * - $correo: dirección de correo de la cuenta.
     * - $clave: clave introducida durante el inicio de sesión.
     *
     * Retorno:
     * - Objeto Registrar si el correo existe y la clave es correcta.
     * - null si las credenciales no coinciden.
     *
     * La clave no se incluye en el objeto devuelto.
     */
    public function verificar($correo, $clave) {
        $registro = null;

        try {
            // Busca la cuenta por correo y recupera el hash almacenado.
            $stmt = $this->conn->prepare(
                "SELECT id, Nombre, correo, Clave, TipoCuenta
                 FROM registrar WHERE correo = ?"
            );

            $stmt->execute(array($correo));

            // Obtiene los datos de la cuenta encontrada.
            $reg = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica la clave comparándola con el hash almacenado.
            if ($reg && password_verify($clave, $reg['Clave'])) {
                $registro = new Registrar(
                    $reg['id'],
                    $reg['Nombre'],
                    $reg['correo'],
                    null,
                    null,
                    $reg['TipoCuenta']
                );
            }
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $registro;
    } // Fin del método verificar()


    /* 11. CONTEO DE REGISTROS
     * contar() obtiene la cantidad total de registros existentes en la
     * tabla registrar. Este método puede utilizarse para mostrar estadísticas
     * y el número de usuarios en el panel administrativo.
     *
     * Retorno:
     * - Número entero con el total de registros.
     * - 0 si el resultado obtenido es cero.
     */
    public function contar() {
        $total = 0;

        try {
            // COUNT(*) calcula la cantidad total de filas de la tabla.
            $stmt = $this->conn->query(
                "SELECT COUNT(*) FROM registrar"
            );

            // Recupera el resultado y lo convierte en un número entero.
            $total = (int) $stmt->fetchColumn();
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $total;
    } // Fin del método contar()

} // Fin de la clase Registrarctrl

?>
