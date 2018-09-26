<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 24/9/2018
 * Time: 19:32
 */

namespace Dao;


use Modelo\PlazaEvento;

class PlazaEventoBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "plaza_eventos";

    public function traerPorIdCalendario($id){
        try {
            $sql = ("SELECT pe.* FROM $this->tabla pe INNER JOIN calendarios ca 
                ON ca.id_calendario=pe.id_calendario WHERE ca.id_calendario=$id");
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
            echo "ERROR-PLAZAEVENTOBASEDEDATOS: {$e->getMessage()}";
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
    public function save($data)
    {
        try{
            $sql = ("INSERT INTO $this->tabla 
              (capacidad,remanente,id_tipo_plaza,id_calendario,id_sede,precio) 
              VALUES (:capacidad, :remanente, :id_tipo_plaza, :id_calendario, :id_sede,:precio)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $capacidad = $data->getCapacidad();
            $remanente = $data->getRemanente();
            $precio = $data->getPrecio();
            $plaza = $data->getPlaza();
            $calendario = $data->getCalendario();
            $sede = $data->getSede();
            $id_plaza = $plaza->getId();
            $id_calendario = $calendario->getId();
            $id_sede = $sede->getId();
            $sentencia->bindParam(":capacidad",$capacidad);
            $sentencia->bindParam(":remanente",$remanente);
            $sentencia->bindParam(":id_tipo_plaza",$id_plaza);
            $sentencia->bindParam(":id_calendario",$id_calendario);
            $sentencia->bindParam(":id_sede",$id_sede);
            $sentencia->bindParam(":precio",$precio);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_PLAZAEVENTOS_SAVE: {$e->getMessage()}";
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

            $sql = "DELETE FROM $this->tabla WHERE id_plaza_evento=\"$id\" ";

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
            $sql = "SELECT * FROM $this->tabla WHERE id_plaza_evento=$id";
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
        $this->listado = array_map(function($p) {
            $plazaDao = TipoPlazaBdDao::getInstance();
            $calendarioDao = CalendarioBdDao::getInstance();
            $sedeDao = SedeBdDao::getInstance();
            $plaza = $plazaDao->retrieve($p['id_tipo_plaza']);
            $calendario = $calendarioDao->retrieve($p['id_calendario']);
            $sede = $sedeDao->retrieve($p['id_sede']);
            $plazaEvento = new PlazaEvento(
                $p['capacidad'],$p['remanente'],$sede,$plaza,$calendario,$p['precio']);
            $plazaEvento->setId($p['id_plaza_evento']);
            return $plazaEvento;
        }, $dataSet);
        //}
    }
}