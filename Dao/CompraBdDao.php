<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 2/10/2018
 * Time: 20:20
 */

namespace Dao;


use Modelo\Compra;

class CompraBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "compras";

    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (fecha,total,id_cliente) VALUES (:fecha,:total,:id_cliente)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $fecha = $data->getFecha();
            $total = $data->getTotal();
            $cliente = $data->getCliente();
            $id_cliente = $cliente->getId();
            $sentencia->bindParam(":fecha",$fecha);
            $sentencia->bindParam(":total",$total);
            $sentencia->bindParam(":id_cliente",$id_cliente);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_COMPRA_SAVE: {$e->getMessage()}";
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
            $sql = "SELECT * FROM $this->tabla WHERE id_compra= $id ";
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

    public function traerPorIdCliente($id){
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_cliente=\"$id\" ";
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
            echo "Hubo un error en compra: {$e->getMessage()}";
            die();
        }
    }

    private function mapear($dataSet){
        $dataSet = is_array($dataSet) ? $dataSet : [];
        //if($dataSet[0]) {
        $this->listado = array_map(function ($p) {
            $clienteDao = ClienteBdDao::getInstance();
            $cliente = $clienteDao->retrieve($p['id_cliente']);
            $compra = new Compra($cliente,$p['total'],$p['fecha']);
            $compra->setId($p['id_compra']);
            return $compra;
        }, $dataSet);
        //}
    }
}