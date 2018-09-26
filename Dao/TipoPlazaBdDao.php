<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 15:41
 */

namespace Dao;


use Dao\IDao;
use Dao\SingletonDao;
use Modelo\TipoPlaza;
use Dao\SedeBdDao;

class TipoPlazaBdDao extends SingletonDao implements IDao
{
    private $tabla = "tipo_plazas";
    private $listado = [];

    public  function descripcionExists($descripcion){
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
    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (descripcion, id_sede) VALUES (:descripcion, :id_sede)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $descripcion = $data->getDescripcion();
            $sede = $data->getSede();
            $id = $sede->getId();
            $sentencia->bindParam(":descripcion",$descripcion);
            $sentencia->bindParam(":id_sede",$id);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_TIPOPLAZA_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function traerPorIdSede($id){
        try {
            $sql = "SELECT * FROM $this->tabla WHERE id_sede = $id";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado)) {
                return $this->listado;
            }
            return null;
        }catch (\PDOException $e){
            echo 'ERROR EN BASE DE DATOS';die();
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
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_tipo_plaza=$id";
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

            $sedeDao = SedeBdDao::getInstance();
            $sede = $sedeDao->retrieve($p['id_sede']);
            $tipoPlaza = new TipoPlaza($p['descripcion'],$sede);
            $tipoPlaza->setId($p['id_tipo_plaza']);
            return $tipoPlaza;
        }, $dataSet);
        //}
    }

}