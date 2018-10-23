<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 3/10/2018
 * Time: 19:35
 */

namespace Dao;


use Modelo\Linea;

class LineaBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "lineas";
    public function save($data)
    {
        try{
            $sql = ("INSERT INTO  $this->tabla (subtotal,id_plaza_evento,id_compra,cantidad, id_promo) VALUES (:subtotal,:id_plaza_evento,:id_compra,:cantidad,:id_promo)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $subtotal = $data->getSubtotal();
            $plazaEvento = $data->getPlazaEvento();
            $id_plaza_evento = $plazaEvento->getId();
            $compra = $data->getCompra();
            $cantidad = $data->getCantidad();
            $id_compra = $compra->getId();

            $promo = $data->getPromo();

            if($promo){
              $id_promo = $promo->getId();
            }else $id_promo = null;

            $sentencia->bindParam(":subtotal",$subtotal);
            $sentencia->bindParam(":id_plaza_evento",$id_plaza_evento);
            $sentencia->bindParam(":cantidad",$cantidad);
            $sentencia->bindParam(":id_compra",$id_compra);
            $sentencia->bindParam(":id_promo",$id_promo);
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

    public function retrieve($id)
    {
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_linea= $id ";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if($dataSet[0]){
                $this->mapear($dataSet);
            }
            if (!empty($this->listado)) {
                return $this->listado[0];
            }
            return false;
        }catch (\PDOException $e){
            echo "Hubo un error en Linea: {$e->getMessage()}";
            die();
        }
    }

    public function traerPorIdPlazaEvento($id_plaza){
        try{
            $sql = ("SELECT li.* FROM $this->tabla li INNER JOIN plaza_eventos pe
                ON pe.id_plaza_evento=li.id_plaza_evento WHERE pe.id_plaza_evento=$id_plaza");
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
            echo "Hubo un error: {$e->getMessage()}";
            die();
        }
    }

    function traerPorIdCompra($id){
        try{
            $sql = ("SELECT * FROM $this->tabla WHERE id_compra = \"$id\" ");
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
            echo "Hubo un error en Linea: {$e->getMessage()}";
            die();
        }
    }
    private function mapear($dataSet){
        $dataSet = is_array($dataSet) ? $dataSet : [];
        //if($dataSet[0]) {
        $this->listado = array_map(function ($p) {
            $plazaEventoDao = PlazaEventoBdDao::getInstance();
            $compraDao = CompraBdDao::getInstance();
            $promoDao  = PromoBdDao::getInstance();
            $promo = $promoDao->retrieve($p['id_promo']);
            $plazaEvento = $plazaEventoDao->retrieve($p['id_plaza_evento']);
            $compra = $compraDao->retrieve($p['id_compra']);
            $linea = new Linea($plazaEvento,$p['cantidad'],$p['subtotal'],$compra);
            if($promo){
              $linea->setPromo($promo);
            }
            $linea->setId($p['id_linea']);
            return $linea;
        }, $dataSet);
        //}
    }

}
