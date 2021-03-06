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
use Modelo\EventoImagen;

class EventoBdDao extends SingletonDao implements IDao
{
    private $tabla = "eventos";
    private $listado = [];

    public function traerPorIdCategoria($id_categoria){
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_categoria=\"$id_categoria\" ";
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

    public function  traerPorIdArtista($id){
        try {
            $sql = ("SELECT DISTINCT ev.* FROM $this->tabla ev inner join calendarios ca inner join shows sh INNER join artistas ar on ev.id_evento=ca.id_evento AND
                  ca.id_calendario=sh.id_calendario AND
                  ar.id_artista=sh.id_artista WHERE ar.id_artista=$id");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if(!empty($this->listado)){
                return $this->listado;
            }
            return false;
        }catch (\PDOException $e){
            throw $e;
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
            $sql = ("INSERT INTO  $this->tabla
            (titulo,fecha_desde,fecha_hasta,id_categoria, id_imagen,descripcion)
                    VALUES
            (:titulo,:fecha_desde,:fecha_hasta,:id_categoria, :id_imagen, :descripcion)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $titulo = $data->getTitulo();
            $fecha_desde = $data->getFechaDesde();
            $fecha_hasta = $data->getFechaHasta();
            $categoria = $data->getCategoria();
            $id_categoria = $categoria->getId();
            $imagen = $data->getEventoImagen();
            $descripcion = $data->getDescripcion();
            if($imagen){
                $id_imagen = $imagen->getId();
            }else $id_imagen = null;
            $sentencia->bindParam(":titulo",$titulo);
            $sentencia->bindParam(":fecha_desde",$fecha_desde);
            $sentencia->bindParam(":fecha_hasta",$fecha_hasta);
            $sentencia->bindParam(":id_categoria",$id_categoria);
            $sentencia->bindParam(":id_imagen", $id_imagen);
            $sentencia->bindParam(":descripcion",$descripcion);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_EVENTO_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function update($data)
    {
        try {
            $sql = ( "UPDATE $this->tabla
                SET titulo = :titulo, fecha_desde = :fecha_desde, fecha_hasta = :fecha_hasta,
                 id_categoria = :id_categoria, id_imagen = :id_imagen, descripcion=:descripcion
                  WHERE id_evento = :id" );

            $conexion = Conexion::conectar();

            $sentencia = $conexion->prepare($sql);

            $titulo = $data->getTitulo();
            $fecha_desde = $data->getFechaDesde();
            $fecha_hasta = $data->getFechaHasta();
            $categoria = $data->getCategoria();
            $id_categoria = $categoria->getId();
            $eventoImagen = $data->getEventoImagen();
            $id_imagen = $eventoImagen->getId();
            $id_evento = $data->getId();
            $descripcion = $data->getDescripcion();

            $sentencia->bindParam(":titulo", $titulo);
            $sentencia->bindParam(":fecha_desde", $fecha_desde);
            $sentencia->bindParam(":fecha_hasta", $fecha_hasta);
            $sentencia->bindParam(":id_categoria", $id_categoria);
            $sentencia->bindParam(":id_imagen",$id_imagen);
            $sentencia->bindParam(":descripcion",$descripcion);
            $sentencia->bindParam(":id",$id_evento);

            $sentencia->execute();
        }catch (\PDOException $e){
            echo "ERROR_UPDATE_EVENTO: {$e->getMessage()}";die();
        }
    }

    public function delete($data)
    {
        try{
            $id = $data->getId();
            $sql = "DELETE FROM $this->tabla WHERE id_evento=\"$id\" ";

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
            $sql = "SELECT * FROM $this->tabla WHERE id_evento=$id";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if($dataSet[0]) {
                $this->mapear($dataSet);
            }
            if (!empty($this->listado[0])) {
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
            $evento = new Evento($p['titulo'],$p['fecha_desde'],$p['fecha_hasta'],$categoria,$p['descripcion']);
            $evento->setId($p['id_evento']);
            if($p['id_imagen']){
                $imagenDao = EventoImagenBdDao::getInstance();
                $imagen = $imagenDao->retrieve($p['id_imagen']);
                $evento->setEventoImagen($imagen);
            }
            return $evento;
        }, $dataSet);
    }
}
