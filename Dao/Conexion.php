<?php

namespace Dao;

class Conexion
{
    public static function conectar()
    {
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        /*
         * dsn: EL Nombre del Origen de Datos (DSN), contiene la información requerida
         * para conectarse a la base de datos.
         *
         * dsn está formado por uri: seguido por un URI que define la ubicación de un
         * fichero que contiene el string del DSN. El URI puede especificar un fichero
         * local o un URL remoto.
         */
        $dsn = "mysql:host=$host;dbname=$db;";

        /*
         * Creo el objeto PDO y le seteo que devuelva errores.
         */
        $dbh = new \PDO($dsn, $user, $pass, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));


        if ($dbh) {
            return $dbh;
        } else {
            throw new \PDOException;
        }
    }
}
