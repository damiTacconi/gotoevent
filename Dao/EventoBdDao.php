<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 19:51
 */

namespace Dao;
use Dao\CategoriaBdDao;
use Modelo\Categoria;
use Modelo\Evento;

class EventoBdDao extends SingletonDao implements IDao
{
    private $tabla = "eventos";
    private $listado = [];

    public function getFechas($id){
        try{
            $sql = "SELECT fecha_desde, fecha_hasta FROM $this->tabla WHERE id_evento=$id";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if (!empty($dataSet[0])) {
                return $dataSet[0];
            }
            return false;
        }catch (\PDOException $e){
            echo "Hubo un error: {$e->getMessage()}";
            die();
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

    function titleExists($titulo){
        try{
            $sql = "SELECT titulo FROM $this->tabla WHERE titulo= \"$titulo\" LIMIT 1 ";
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
            $sql = ("INSERT INTO  $this->tabla (titulo,fecha_desde,fecha_hasta,id_categoria) 
                    VALUES (:titulo,:fecha_desde,:fecha_hasta,:id_categoria)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $titulo = $data->getTitulo();
            $fecha_desde = $data->getFechaDesde();
            $fecha_hasta = $data->getFechaHasta();
            $categoria = $data->getCategoria();
            $id_categoria = $categoria->getId();
            $sentencia->bindParam(":titulo",$titulo);
            $sentencia->bindParam(":fecha_desde",$fecha_desde);
            $sentencia->bindParam(":fecha_hasta",$fecha_hasta);
            $sentencia->bindParam(":id_categoria",$id_categoria);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_EVENTO_SAVE: {$e->getMessage()}";
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
            $sql = "SELECT * FROM $this->tabla WHERE id_evento=$id";
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
            $categoriaDao = CategoriaBdDao::getInstance();
            $categoria = $categoriaDao->retrieve($p['id_categoria']);
            $evento = new Evento($p['titulo'],$p['fecha_desde'],$p['fecha_hasta'],$categoria);
            $evento->setId($p['id_evento']);
            return $evento;
        }, $dataSet);
    }
}