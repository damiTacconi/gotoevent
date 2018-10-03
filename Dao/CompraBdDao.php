<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 2/10/2018
 * Time: 20:20
 */

namespace Dao;


class CompraBdDao extends SingletonDao implements IDao
{

    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (descripcion) VALUES (:descripcion)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $nombre = $data->getNombre();
            $sentencia->bindParam(":descripcion",$nombre);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_SEDE_SAVE: {$e->getMessage()}";
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