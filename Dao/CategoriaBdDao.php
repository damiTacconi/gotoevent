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

    public function traerPorDescripcion($desc){
        try{
            $sql = "SELECT * FROM $this->tabla WHERE descripcion=\"$desc\" LIMIT 1";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if($dataSet[0]){
                $this->mapear($dataSet);
            }
            if(!empty($this->listado)){
                return $this->listado[0];
            }
            return false;
        }catch(\PDOException $e){
            die("ERROR: {$e->getMessage() }");
        }
    }

    public function descripcionExists($descripcion){
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
      try {
          $sql = "UPDATE $this->tabla SET descripcion=:descripcion WHERE id_categoria = :id_categoria";
          $conexion = Conexion::conectar();

          $sentencia = $conexion->prepare($sql);

          $descripcion = $data->getDescripcion();
          $id = $data->getId();

          $sentencia->bindParam(":descripcion", $descripcion);
          $sentencia->bindParam(":id_categoria",$id);
          $sentencia->execute();
      }catch (\PDOException $e){
          die("OCURRIO UN ERROR EN BASE DE DATOS");
      }
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
            throw $e;
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
