<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:44
 */

namespace Dao;


class CalendarioBdDao extends SingletonDao implements IDao
{

    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (fecha) VALUES (:fecha)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $fecha = $data->getFecha();
            $sentencia->bindParam(":fecha",$fecha);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_CALENDARIODB_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function update($data)
    {
        // TODO: Implement update() method.
    }

    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    public function retrieve($id)
    {
        // TODO: Implement retrieve() method.
    }
}