<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 25/9/2018
 * Time: 15:53
 */

namespace Dao;


use Modelo\EventoImagen;

class EventoImagenBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "imagenes";

    public function retrieve($id)
    {
        try{
            $sql = "SELECT * FROM $this->tabla WHERE id_imagen=$id";
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
            $eventoImagen = new EventoImagen($p['nombre'],$p['imagen']);
            $eventoImagen->setId($p['id_imagen']);
            return $eventoImagen;
        }, $dataSet);
    }

    public function save($data)
    {
        try{
            $sql = "INSERT INTO  $this->tabla (nombre,imagen)  VALUES (:nombre, :imagen)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $nombre = $data->getNombre();
            $imagen = $data->getImagen();
            $sentencia->bindParam(":nombre",$nombre);
            $sentencia->bindParam(":imagen",$imagen);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_EVENTOIMAGEN_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function update($data)
    {
        try {
            $sql = "UPDATE $this->tabla 
                SET nombre = :nombre, imagen = :imagen WHERE id_imagen = :id";

            $conexion = Conexion::conectar();

            $sentencia = $conexion->prepare($sql);

            $nombre = $data->getNombre();
            $imagen = $data->getImagen();
            $id = $data->getId();

            $sentencia->bindParam(":nombre", $nombre);
            $sentencia->bindParam(":imagen", $imagen);
            $sentencia->bindParam(":id", $id);

            $sentencia->execute();
        }catch (\PDOException $e){
            echo "ERROR_UPDATE_EVENTOIMAGEN: {$e->getMessage()}";die();
        }
    }

    public function delete($data)
    {
        // TODO: Implement delete() method.
    }
}