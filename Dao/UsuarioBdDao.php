<?php

namespace Dao;

use Modelo\Cliente;
use Modelo\Usuario;

class UsuarioBdDao extends SingletonDao implements IDao
{
    protected $tabla = "usuarios";
    protected $listado = [];

    public function update($data)
    {
        // TODO: Implement update() method.
    }

    public function delete($data)
    {
        try{
            $id = $data->getId();

            $sql = "DELETE FROM $this->tabla WHERE id_usuario=\"$id\" ";

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
            $sql = "SELECT * FROM $this->tabla WHERE id_usuario= $id ";
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


    public function verificarUsuario($email,$password){
        try {
            $sql = "select email from usuarios where email= \"$email\" and password=\"$password\"";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if (!empty($dataSet[0])) {
                return true;
            }
            return false;
        }catch (\PDOException $e){
            echo "ERROR EN BASE DE DATOS: {$e->getMessage()}";
            die();
        }
    }
    public function verificarEmail($email){
        try {
            $sql = "SELECT email FROM $this->tabla WHERE email= \"$email\" ";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dato = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if ($dato != null)
                return true;
            return false;
        }catch (\PDOException $e){
            echo "ERROR EN BASE DE DATOS: {$e->getMessage()}";
            die();
        }
    }
    public function save($usuario)
    {
        /** @noinspection SqlResolve */
        $sql = "INSERT INTO $this->tabla (email, password) VALUES (:email, :password)";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $mail = $usuario->getEmail();
        $pwd = $usuario->getPassword();

        $sentencia->bindParam(":email", $mail);
        $sentencia->bindParam(":password", $pwd);

        $sentencia->execute();

        return $conexion->lastInsertId();
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

    public function traerPorEmail($mail)
    {
        /** @noinspection SqlResolve */
        $sql = "SELECT * FROM $this->tabla WHERE email =  \"$mail\" LIMIT 1";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();

        $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);

        $this->mapear($dataSet);

        if (!empty($this->listado[0])) {
            return $this->listado[0];
        }
        return null;
    }

    public function mapear($dataSet)
    {
        $dataSet = is_array($dataSet) ? $dataSet : [];
        $this->listado = array_map(function ($p) {
            $u = new Usuario($p['email'], $p['password']);
            $u->setId($p['id_usuario']);
            return $u;
        }, $dataSet);
    }
}
