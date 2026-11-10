<?php
/**
 * contactoctrl.php
 *
 * @autor: Thomas Lopera Muñoz
 * @fecha: 17/09/2026
 * @descripción: Controlador para el modelo 'contacto' a la base de datos
 *
 * Clase Contactoctrl: accede a la tabla 'contacto' (los mensajes que llegan
 * desde el formulario de contacto) con PDO y sentencias preparadas, y trabaja
 * con objetos de la clase Contacto (Model/contacto.php).
 *
 * Campos de la tabla: id, Nombre, correo, telefono, asunto, mensaje.
 *
 * Métodos:
 *   listar()            todos los contactos, como un arreglo de objetos Contacto
 *   insertar($contacto) guarda un contacto nuevo
 *   buscarPorId($id)    un contacto por su id, o null si no existe
 *   actualizar($contacto) modifica un contacto existente
 *   eliminar($id)       borra un contacto
 *   contar()            total de contactos
 *
 * Quién la usa: contacto.php (insertar), sugerencias.php (listar),
 * editar_contacto.php (buscarPorId y actualizar), eliminar_contacto.php
 * (eliminar) y dashboard.php (contar).
 *
 * Manejo de errores: todos los métodos capturan cualquier excepción y detienen
 * la página con die() mostrando el mensaje del error.
 */

require_once(__DIR__ . '/conexionbd.php');
require_once(__DIR__ . '/../model/contacto.php');

class Contactoctrl
{
    // Objeto Contacto temporal que usa listar() y buscarPorId() al armar los resultados.
    private $contactoMdl;

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
     * Retorna todos los registros de la tabla 'contacto'.
     *
     * @return Contacto[] Arreglo de objetos Contacto; vacío si no hay registros.
     */
    public function listar()
    {
        $contactos = array();
        try {
            $stmt = $this->conn->prepare("SELECT id, Nombre, correo, telefono, asunto, mensaje FROM contacto");
            $stmt->execute();
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                foreach ($resultSet as $con) {
                    $this->contactoMdl = new Contacto($con['id'], $con['Nombre'], $con['correo'], $con['telefono'], $con['asunto'], $con['mensaje']);
                    $contactos[] = $this->contactoMdl;
                }
            }
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $contactos;
    }

    /**
     * Inserta un contacto nuevo. El id lo genera la base de datos.
     *
     * @param Contacto $contacto Objeto con nombre, correo, teléfono, asunto y mensaje.
     * @return bool|int Verdadero si se guardó, falso si falló (0 si hubo una excepción).
     */
    public function insertar($contacto)
    {
        $insertado = 0;
        try {
            $stmt = "INSERT INTO contacto (Nombre, correo, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)";
            $con = array($contacto->getNombre(), $contacto->getCorreo(), $contacto->getTelefono(), $contacto->getAsunto(), $contacto->getMensaje());

            $insertado = $this->conn->prepare($stmt)->execute($con);
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $insertado;
    }

    /**
     * Retorna un contacto por su id.
     *
     * @param int $id Id del contacto.
     * @return Contacto|null El contacto, o null si no existe.
     */
    public function buscarPorId($id)
    {
        $contacto = null;
        try {
            $stmt = $this->conn->prepare("SELECT id, Nombre, correo, telefono, asunto, mensaje FROM contacto WHERE id = ?");
            $stmt->execute(array($id));
            $con = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($con) {
                $contacto = new Contacto($con['id'], $con['Nombre'], $con['correo'], $con['telefono'], $con['asunto'], $con['mensaje']);
            }
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $contacto;
    }

    /**
     * Actualiza todos los campos de un contacto existente.
     *
     * @param Contacto $contacto Objeto con los datos nuevos; su id indica qué registro modificar.
     * @return bool|int Verdadero si la consulta se ejecutó, falso si falló (0 si hubo una excepción).
     */
    public function actualizar($contacto)
    {
        $actualizado = 0;
        try {
            $stmt = "UPDATE contacto SET Nombre = ?, correo = ?, telefono = ?, asunto = ?, mensaje = ? WHERE id = ?";

            $actualizado = $this->conn->prepare($stmt)->execute(array($contacto->getNombre(), $contacto->getCorreo(), $contacto->getTelefono(), $contacto->getAsunto(), $contacto->getMensaje(), $contacto->getId()));
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $actualizado;
    }

    /**
     * Elimina un contacto.
     *
     * @param int $idContacto Id del contacto a eliminar.
     * @return bool|int Verdadero si la consulta se ejecutó, falso si falló (0 si hubo una excepción).
     */
    public function eliminar($idContacto)
    {
        $eliminado = 0;
        try {
            $stmt = $this->conn->prepare("DELETE FROM contacto WHERE id = ?");
            $eliminado = $stmt->execute(array($idContacto));
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $eliminado;
    }

    /**
     * Retorna el total de registros de la tabla 'contacto'.
     *
     * @return int Cantidad de contactos.
     */
    public function contar()
    {
        $total = 0;
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM contacto");
            $total = (int) $stmt->fetchColumn();
        } catch (Exception $exc) {
            die("Error: " . $exc->getMessage());
        }

        return $total;
    }
}