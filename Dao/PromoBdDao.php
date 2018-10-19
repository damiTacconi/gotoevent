<?php

namespace Dao;


use Modelo\Promo;

class PromoBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "promos";

    public function save($data)
    {
        try{
            $sql = ("INSERT INTO  $this->tabla (descuento,id_evento)
                    VALUES (:descuento,:id_evento)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $descuento = $data->getDescuento();
            $evento = $data->getEvento();
            $id_evento = $evento->getId();
            $sentencia->bindParam(":descuento",$descuento);
            $sentencia->bindParam(":id_evento",$id_evento);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_LINEA_SAVE: {$e->getMessage()}";
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

    public function traerPorIdEvento($id)
    {
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_evento= $id ";
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
    public function retrieve($id)
    {
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_promo= $id ";
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
            $promo = new Promo($p['descuento'], $p['id_evento']);
            $promo->setId($p['id_promo']);
            return $promo;
        }, $dataSet);
        //}
    }

}