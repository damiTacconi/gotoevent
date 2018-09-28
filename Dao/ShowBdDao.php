<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 22/9/2018
 * Time: 17:05
 */

namespace Dao;


use Modelo\Show;
use DateTime;
class ShowBdDao extends SingletonDao implements IDao
{
    private $listado = [];
    private $tabla = "shows";

    public function existsShow($id_artista, $id_calendario){
        try{
            $sql = "SELECT 1 FROM $this->tabla WHERE id_calendario= \"$id_calendario\" AND id_artista= $id_artista ";
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
            $sql = ("INSERT INTO  $this->tabla (id_calendario,id_artista) VALUES (:id_calendario,:id_artista)");
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $calendario = $data->getCalendario();
            $id_calendario = $calendario->getId();
            $artista = $data->getArtista();
            $id_artista = $artista->getId();
            $sentencia->bindParam(":id_calendario",$id_calendario);
            $sentencia->bindParam(":id_artista",$id_artista);

            $sentencia->execute();
            return $conexion->lastInsertId();
        }catch (\PDOException $e){
            echo "EXCEPCION_SHOW_SAVE: {$e->getMessage()}";
            die();
        }
    }

    public function traerPorIdCalendario($id_calendario){
        try {
            $sql = ("SELECT hs.* FROM $this->tabla hs INNER JOIN calendarios ca 
                ON ca.id_calendario=hs.id_calendario WHERE ca.id_calendario=$id_calendario");
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
            echo "ERROR-SHOWBASEDEDATOS: {$e->getMessage()}";
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
            $sql = "SELECT * FROM $this->tabla WHERE id_hora_show=$id";
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
            $calendarioDao = CalendarioBdDao::getInstance();
            $artistaDao = ArtistaBdDao::getInstance();
            $calendario = $calendarioDao->retrieve($p['id_calendario']);
            $artista = $artistaDao->retrieve($p['id_artista']);
            $show = new Show($artista,$calendario);
            $show->setId($p['id_show']);
            return $show;
        }, $dataSet);
    }
}