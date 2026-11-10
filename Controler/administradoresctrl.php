<?php
/**
 * administradoresctrl.php
 *
 * @autor: Thomas Lopera Muñoz
 * @fecha: 17/09/2026
 * @descripción: Controlador para el modelo 'administradores' a la base de datos
 *
 * Clase Administradoresctrl: accede a la tabla 'administradores' con PDO y
 * sentencias preparadas, y trabaja con objetos de la clase Administradores
 * (Model/administradores.php).
 *
 * Campos de la tabla: id, nombre, correo. La tabla no guarda contraseña: es la
 * lista de los correos que tienen permiso de administrador. Las cuentas con
 * contraseña están en la tabla 'registrar'.
 *
 * Métodos:
 *   listar()                    todos los administradores, como un arreglo de objetos
 *   buscarPorId($id)            un administrador por su id, o null si no existe
 *   buscarPorCorreo($correo)    un administrador por su correo, o null si no existe
 *   insertar($administrador)    agrega un administrador
 *   actualizar($administrador)  modifica nombre y correo de un administrador
 *   eliminar($idAdministrador)  borra un administrador
 *
 * Quién la usa: administradores.php (listar), editar_administrador.php
 * (buscarPorId y actualizar), eliminar_administrador.php (eliminar) y
 * registrar.php (buscarPorCorreo, para decidir si una cuenta nueva es de
 * administrador).
 *
 * Manejo de errores: todos los métodos capturan cualquier excepción y detienen
 * la página con die() mostrando el mensaje del error.
 */

require_once(__DIR__ . '/conexionbd.php');
require_once(__DIR__ . '/../model/administradores.php');

class Administradoresctrl
{
    // Objeto Administradores temporal que usa listar() al armar los resultados.
    private $administradorMdl;

    // Conexión PDO a la base de datos.
    private $conn;

    /**
     * Obtiene la conexión a la base de datos al crear el controlador.
     */
    public function __construct()
    {
        $this->conn = ConexionBD::getConn();
    }

    /**
     * Retorna todos los registros de la tabla 'administradores'.
     *
     * @return Administradores[] Arreglo de objetos Administradores; vacío si no hay registros.
     */
    public function listar()
    {
        $administradores = array();

        try {
            // Consulta los administradores registrados
            $stmt = $this->conn->prepare(
                "SELECT id, nombre, correo FROM administradores"
            );

            $stmt->execute();

            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {

                foreach ($resultSet as $adm) {

                    // Convierte cada registro de la base de datos
                    // en un objeto Administradores
                    $this->administradorMdl = new Administradores(
                        $adm['id'],
                        $adm['correo'],
                        $adm['nombre']
                    );

                    $administradores[] = $this->administradorMdl;
                }
            }

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $administradores;
    }

    /**
     * Retorna un administrador según su id.
     *
     * @param int $id Id del administrador.
     * @return Administradores|null El administrador, o null si no existe.
     */
    public function buscarPorId($id)
    {
        $administrador = null;

        try {
            // Consulta el administrador utilizando su identificador.
            $stmt = $this->conn->prepare(
                "SELECT id, nombre, correo
                 FROM administradores
                 WHERE id = ?"
            );

            // Ejecuta la consulta utilizando el id recibido.
            $stmt->execute(array($id));

            // Obtiene el registro encontrado.
            $adm = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si existe el administrador, crea el objeto correspondiente.
            if ($adm) {
                $administrador = new Administradores(
                    $adm['id'],
                    $adm['correo'],
                    $adm['nombre']
                );
            }

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        // Retorna el objeto administrador o null si no existe.
        return $administrador;
    }

    /**
     * Retorna el administrador que tiene ese correo.
     * registrar.php lo usa para saber si una cuenta nueva debe ser de administrador.
     *
     * @param string $correo Correo a buscar.
     * @return Administradores|null El administrador, o null si no existe.
     */
    public function buscarPorCorreo($correo)
    {
        $administrador = null;

        try {
            // Busca el administrador por su correo
            $stmt = $this->conn->prepare(
                "SELECT id, nombre, correo
                 FROM administradores
                 WHERE correo = ?"
            );

            $stmt->execute(array($correo));

            $adm = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($adm) {

                // Convierte el registro encontrado en un objeto
                $administrador = new Administradores(
                    $adm['id'],
                    $adm['correo'],
                    $adm['nombre']
                );
            }

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $administrador;
    }

    /**
     * Inserta un administrador nuevo. El id lo genera la base de datos.
     *
     * @param Administradores $administrador Objeto con nombre y correo.
     * @return bool|int Verdadero si se guardó, falso si falló (0 si hubo una excepción).
     */
    public function insertar($administrador)
    {
        $insertado = 0;

        try {
            // Inserta el nombre y correo del administrador
            $stmt = "INSERT INTO administradores (nombre, correo)
                     VALUES (?, ?)";

            $adm = array(
                $administrador->getNombre(),
                $administrador->getCorreo()
            );

            $insertado = $this->conn->prepare($stmt)->execute($adm);

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $insertado;
    }

    /**
     * Actualiza el nombre y el correo de un administrador existente.
     *
     * @param Administradores $administrador Objeto con los datos nuevos; su id indica qué registro modificar.
     * @return bool|int Verdadero si la consulta se ejecutó, falso si falló (0 si hubo una excepción).
     */
    public function actualizar($administrador)
    {
        $actualizado = 0;

        try {
            // Actualiza el nombre y correo usando el id
            $stmt = "UPDATE administradores
                     SET nombre = ?, correo = ?
                     WHERE id = ?";

            $actualizado = $this->conn->prepare($stmt)->execute(
                array(
                    $administrador->getNombre(),
                    $administrador->getCorreo(),
                    $administrador->getId()
                )
            );

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $actualizado;
    }

    /**
     * Elimina un administrador.
     *
     * @param int $idAdministrador Id del administrador a eliminar.
     * @return bool|int Verdadero si la consulta se ejecutó, falso si falló (0 si hubo una excepción).
     */
    public function eliminar($idAdministrador)
    {
        $eliminado = 0;

        try {
            // Elimina el administrador usando su id
            $stmt = $this->conn->prepare(
                "DELETE FROM administradores WHERE id = ?"
            );

            $eliminado = $stmt->execute(
                array($idAdministrador)
            );

        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $eliminado;
    }
}