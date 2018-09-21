<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 08:49
 */

namespace Dao;
use Modelo\Artista;

class ArtistaBdDao extends SingletonDao implements IDao
{
    private $tabla = "artistas";
    private $listado = [];

    public function artistExists($nombre){
        try{
            $sql = "SELECT nombre FROM $this->tabla WHERE nombre= \"$nombre\" LIMIT 1 ";
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

    public  function getAll(){
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
            $sql = "INSERT INTO  $this->tabla (nombre) VALUES (:nombre)";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $nombre = $data->getNombre();
            $sentencia->bindParam(":nombre",$nombre);
            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_ARTISTASBD_SAVE: {$e->getMessage()}";
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

            $sql = "DELETE FROM $this->tabla WHERE id_artista=\"$id\" ";

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
            $sql = "SELECT * FROM $this->tabla WHERE id_artista=$id";
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
            $artista = new Artista($p['nombre']);
            $artista->setId($p['id_artista']);
            return $artista;
        }, $dataSet);
        //}
    }

}