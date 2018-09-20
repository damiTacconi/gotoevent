<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 15:54
 */

namespace Dao;

class CategoriaBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "categorias";

    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (descripcion) VALUES (:descripcion)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $descripcion = $data->getDescripcion();
            $sentencia->bindParam(":descripcion",$descripcion);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_CATEGORIASBD_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function DescripcionExists($descripcion){
        try{
            $sql = "SELECT descripcion FROM $this->tabla WHERE descripcion= \"$descripcion\" LIMIT 1 ";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if (!empty($dataSet[0])) {
                return true;
            }
            return false;
        }catch (\PDOException $e){
            return true;
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