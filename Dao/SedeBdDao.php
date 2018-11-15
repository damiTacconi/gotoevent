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


    public function traerPorIdEvento($id_evento){
        try{
        $sql = ("select DISTINCT se.* from $this->tabla se inner join calendarios ca inner join
        eventos ev on ca.id_evento = ev.id_evento and ca.id_sede = se.id_sede
        WHERE ev.id_evento = \"$id_evento\" ");
        $conexion = Conexion::conectar();
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        $this->mapear($dataSet);
        if (!empty($this->listado)) {
            return $this->listado;
        }
        return false;

        }catch(\PDOException $e){
            die("OCURRIO UN ERROR EN TAER_ID_EVENTO - SEDEBD || {$e->getMessage() }");
        }

    }
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
            $sql = "INSERT INTO  $this->tabla (descripcion , capacidad) VALUES (:descripcion,:capacidad)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $nombre = $data->getNombre();
            $capacidad = $data->getCapacidad();
            $sentencia->bindParam(":descripcion",$nombre);
            $sentencia->bindParam(":capacidad",$capacidad);
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
            $sql = "UPDATE $this->tabla SET descripcion=:descripcion, capacidad=:capacidad
            WHERE id_sede = :id_sede";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $nombre = $data->getNombre();
            $capacidad = $data->getCapacidad();
            $sentencia->bindParam(":descripcion", $nombre);
            $sentencia->bindParam(":capacidad",$capacidad);
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
            throw $e;
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
            $sede = new Sede($p['descripcion'],$p['capacidad']);
            $sede->setId($p['id_sede']);
            return $sede;
        }, $dataSet);
        //}
    }


}
