<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 3/10/2018
 * Time: 19:40
 */

namespace Dao;


use Modelo\Ticket;

class TicketBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "tickets";
    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (numero,fecha,qr,id_linea) VALUES (:numero,:fecha,:qr,:id_linea)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $numero = $data->getNumero();
            $fecha = $data->getFecha();
            $qr = $data->getQr();
            $linea = $data->getLinea();
            $id_linea = $linea->getId();
            $sentencia->bindParam(":numero",$numero);
            $sentencia->bindParam(":fecha",$fecha);
            $sentencia->bindParam(":qr",$qr);
            $sentencia->bindParam(":id_linea",$id_linea);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_TICKET_SAVE: {$e->getMessage()}";
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
            $sql = "SELECT * FROM $this->tabla WHERE id_ticket= $id ";
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
            $lineaDao = LineaBdDao::getInstance();
            $linea = $lineaDao->retrieve($p['id_linea']);
            $ticket = new Ticket($p['fecha'],$p['numero'],$linea,$p['qr']);
            $ticket->setId($p['id_linea']);
            return $ticket;
        }, $dataSet);
        //}
    }

}