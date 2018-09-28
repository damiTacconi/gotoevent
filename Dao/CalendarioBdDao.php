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
use Modelo\Show;

class CalendarioBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "calendarios";


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
    public function fechaExists($id_evento, $fecha){
        try{
            $sql = "SELECT fecha FROM $this->tabla WHERE (fecha= \"$fecha\" AND id_evento= \"$id_evento\" ) LIMIT 1 ";
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
            $evento = $data->getEvento();
            $id_evento = $evento->getId();
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
        try{
            $id = $data->getId();

            $sql = "DELETE FROM $this->tabla WHERE id_calendario=\"$id\" ";

            $conexion = Conexion::conectar();

            $sentencia = $conexion->prepare($sql);

            $sentencia->execute();

        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }

    public function traerPorFecha($fecha){
        try{
            $sql = "SELECT * FROM $this->tabla WHERE fecha=:fecha";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(":fecha",$fecha);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado)) {
                return $this->listado[0];
            }
            return null;
        }catch (\PDOException $e){
            echo "ERROR_TRAERPORFECHA: {$e->getMessage()}";
        }
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
            $eventoDao = EventoBdDao::getInstance();
            $evento = $eventoDao->retrieve($p['id_evento']);
            $calendario = new Calendario($p['fecha'],$evento);

            $calendario->setId($p['id_calendario']);
            return $calendario;
        }, $dataSet);
    }
}