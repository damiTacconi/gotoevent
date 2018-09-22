<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:44
 */

namespace Dao;

use DateTime;
use Modelo\Calendario;

class CalendarioBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "calendarios";


    public function fechaExists($fecha){
        try{
            $sql = "SELECT fecha FROM $this->tabla WHERE fecha= \"$fecha\" LIMIT 1 ";
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

    public function traerPorIdEvento($id_evento){
        $sql = ("SELECT ca.* FROM $this->tabla ca INNER JOIN eventos ev 
                ON ev.id_evento=ca.id_evento WHERE ev.id_evento = $id_evento");
        $conexion = Conexion::conectar();
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        $this->mapear($dataSet);
        if(!empty($this->listado)){
            return $this->listado;
        }
        return null;
    }
    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (fecha , id_evento) VALUES (:fecha, :id_evento)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $fecha = $data->getFecha();
            $id_evento = $data->getIdEvento();
            $sentencia->bindParam(":fecha",$fecha);
            $sentencia->bindParam(":id_evento",$id_evento);
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
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_calendario=$id";
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
        $this->listado = array_map(function ($p) {
            $calendario = new Calendario($p['fecha']);
            $calendario->setIdEvento($p['id_evento']);
            $calendario->setId($p['id_calendario']);
            return $calendario;
        }, $dataSet);
    }
}