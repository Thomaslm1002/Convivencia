<?php
    /*
    @autor: Thomas Lopera Muñoz
    @Fecha: 24/09/2026
    @Descripción: Archivo de conexión a la base de datos
    */

    require_once 'properties.php';
    class ConexionBD {
    public static function getConn() {
        // se crea la conexión aplicando UTF-8 para los caracteres especiales
        $link = null;
    try {
        $link = new PDO("mysql:host=" . DB_HOST . ":" . DB_PORT . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    } catch (PDOException $pdoe) {
        exit("Error: " . $pdoe->getMessage());
    }
    return $link;
    }
    }

?>