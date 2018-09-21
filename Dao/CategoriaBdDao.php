<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 15:54
 */

namespace Dao;
use Modelo\Categoria;

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

    public function getAll(){
        try{
            $sql = "SELECT * FROM $this->tabla";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado)) {
                return $this->listado;
            }
            return false;
        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    public function delete($data)
    {
        try{
            $id = $data->getId();

            $sql = "DELETE FROM $this->tabla WHERE id_categoria=\"$id\" ";

            $conexion = Conexion::conectar();

            $sentencia = $conexion->prepare($sql);

            $sentencia->execute();

        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }

    public function retrieve($id)
    {
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_categoria=$id";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado)) {
                return $this->listado[0];
            }
            return false;
        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }

    private function mapear($dataSet){
        $dataSet = is_array($dataSet) ? $dataSet : [];
        //if($dataSet[0]) {
            $this->listado = array_map(function ($p) {
                $categoria = new Categoria($p['descripcion']);
                $categoria->setId($p['id_categoria']);
                return $categoria;
            }, $dataSet);
        //}
    }
}