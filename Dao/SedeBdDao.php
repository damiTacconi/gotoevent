<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 14:39
 */

namespace Dao;

use Modelo\Sede;

class SedeBdDao extends SingletonDao implements IDao
{
    private $tabla = "sedes";
    private $listado = [];

    public function sedeExists($nombre){
        try{
            $sql = "SELECT descripcion FROM $this->tabla WHERE descripcion= \"$nombre\" LIMIT 1 ";
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

    public  function getAll(){
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
        try {
            $sql = "UPDATE $this->tabla SET descripcion=:descripcion WHERE id_sede = :id_sede";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $descripcion = $data->getDescripcion();
            $sentencia->bindParam(":descripcion", $descripcion);
            $sentencia->execute();
        }catch (\PDOException $e){
            die("OCURRIO UN ERROR EN BASE DE DATOS");
        }
    }

    public function delete($data)
    {
        try{
            $id = $data->getId();

            $sql = "DELETE FROM $this->tabla WHERE id_sede=\"$id\" ";

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
            $sql = "SELECT * FROM $this->tabla WHERE id_sede= $id ";
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

    function traerPorId($id){
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_sede= \"$id\" LIMIT 1 ";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado[0])) {
                return $this->listado[0];
            }
            return false;
        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }
    function traerIdPorNombre($nombre){
        try{
            $sql = "SELECT id_sede FROM $this->tabla WHERE descripcion= \"$nombre\" LIMIT 1 ";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if (!empty($dataSet[0]['id_sede'])) {
                return $dataSet[0]['id_sede'];
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
            $sede = new Sede($p['descripcion']);
            $sede->setId($p['id_sede']);
            return $sede;
        }, $dataSet);
        //}
    }


}