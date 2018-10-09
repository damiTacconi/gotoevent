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

    public function traerPorIdEventoYPlaza($id_evento,$plaza ){
      try{
      
        $sql = ("select pe.* from plaza_eventos pe inner join tipo_plazas tp inner join eventos ev
        inner join calendarios ca on pe.id_tipo_plaza=tp.id_tipo_plaza
        and ev.id_evento=ca.id_evento and ca.id_calendario= pe.id_calendario
        WHERE ev.id_evento=\" $id_evento \" AND tp.descripcion=\" $plaza \" ");

        $conexion = Conexion::conectar();
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        $this->mapear($dataSet);
        if (!empty($this->listado)) {
            return $this->listado;
        }
        return null;

      }catch(PDOException $e){
        echo "ERROR-PLAZAEVENTOBASEDEDATOS: {$e->getMessage()}";die();

      }
    }

    public function verificarPlazaExistente($id_calendario, $id_tipo_plaza){
        $sql = ("select 1 from $this->tabla pe inner  join calendarios ca inner join tipo_plazas tp
                on pe.id_calendario = ca.id_calendario AND pe.id_tipo_plaza=tp.id_tipo_plaza
                where  ca.id_calendario = \"$id_calendario\" AND tp.id_tipo_plaza = \"$id_tipo_plaza\" ");
        $conexion = Conexion::conectar();
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
        if($dataSet[0]){
            return true;
        }
        return false;
    }
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
              (capacidad,remanente,id_tipo_plaza,id_calendario,precio)
              VALUES (:capacidad, :remanente, :id_tipo_plaza, :id_calendario,:precio)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $capacidad = $data->getCapacidad();
            $remanente = $data->getRemanente();
            $precio = $data->getPrecio();
            $plaza = $data->getPlaza();
            $calendario = $data->getCalendario();
            $id_plaza = $plaza->getId();
            $id_calendario = $calendario->getId();

            $sentencia->bindParam(":capacidad",$capacidad);
            $sentencia->bindParam(":remanente",$remanente);
            $sentencia->bindParam(":id_tipo_plaza",$id_plaza);
            $sentencia->bindParam(":id_calendario",$id_calendario);
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
        try {
            $sql = ("UPDATE $this->tabla SET capacidad=:capacidad, remanente=:remanente, 
                      id_tipo_plaza=:id_plaza, id_calendario=:id_calendario 
                      WHERE id_plaza_evento = :id_plaza_evento");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $capacidad = $data->getCapacidad();
            $remanente = $data->getRemanente();
            $tipoPlaza = $data->getPlaza();
            $calendario = $data->getCalendario();
            $id_plaza = $tipoPlaza->getId();
            $id_calendario = $calendario->getId();
            $id_plaza_evento = $data->getId();
            $sentencia->bindParam(":capacidad", $capacidad);
            $sentencia->bindParam(":remanente", $remanente);
            $sentencia->bindParam(":id_plaza", $id_plaza);
            $sentencia->bindParam(":id_calendario", $id_calendario);
            $sentencia->bindParam(":id_plaza_evento",$id_plaza_evento);
            $sentencia->execute();
        }catch (\PDOException $e){
            die("OCURRIO UN ERROR EN BASE DE DATOS");
        }
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
            $plaza = $plazaDao->retrieve($p['id_tipo_plaza']);
            $calendario = $calendarioDao->retrieve($p['id_calendario']);
            $plazaEvento = new PlazaEvento(
                $p['capacidad'],$p['remanente'],$plaza,$calendario,$p['precio']);
            $plazaEvento->setId($p['id_plaza_evento']);
            return $plazaEvento;
        }, $dataSet);
        //}
    }
}
