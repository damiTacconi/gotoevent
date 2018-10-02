<?php

namespace Dao;

use Modelo\Cliente;
use Modelo\Usuario;

class ClienteBdDao extends SingletonDao implements IDao
{
    protected $tabla = "clientes";
    protected $listado = [];

    public function verificarDni($dni){
        try {
            $sql = "SELECT dni FROM $this->tabla WHERE dni=$dni";
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dato = $sentencia->fetch(\PDO::FETCH_ASSOC);
            if ($dato == null)
                return false;
            return true;
        }catch (\PDOException $e){
            echo "ERROR_CLIENTE_VERIFICAR_DNI: {$e->getMessage()}";
            die();
        }
    }
    public function save($cliente)
    {
        $sql = <<<TAG
INSERT INTO $this->tabla (nombre, apellido, dni, id_usuario) VALUES (:nombre, :apellido, :dni, :id_usuario)
TAG;

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $dni = $cliente->getDni();
        $id_usuario = $cliente->getIdUsuario();

        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":apellido", $apellido);
        $sentencia->bindParam(":dni", $dni);
        $sentencia->bindParam(":id_usuario", $id_usuario);

        $sentencia->execute();

        return $conexion->lastInsertId();
    }

    public function eliminarPorId($id)
    {
        /** @noinspection SqlResolve */
        $sql = "DELETE FROM $this->tabla WHERE id_cliente = \"$id\"";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();
    }

    public function eliminarPorDni($dni)
    {
        /** @noinspection SqlResolve */
        $sql = "DELETE FROM $this->tabla WHERE dni = \"$dni\"";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();
    }

    public function traerTodo()
    {
        $sql = "SELECT * FROM $this->tabla";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();

        $dataSet = $sentencia->fetchAll(\PDO::FETCH_ASSOC);

        $this->mapear($dataSet);

        if (!empty($this->listado)) {
            return $this->listado;
        }
        return null;
    }

    public function traerPorId($id)
    {
        $sql = "SELECT * FROM $this->tabla WHERE id_cliente =  \"$id\" LIMIT 1";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();

        $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);

        $this->mapear($dataSet);

        if (!empty($this->listado)) {
            return $this->listado[0];
        }
        return null;
    }
    public function traerPorUsuario($email,$password){
        try {
            $sql = "CALL getcliente(\"$email\",\"$password\")"; // getcliente es un STORED PROCEDURE
            $conexion = Conexion::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $dataSet[] = $sentencia->fetch(\PDO::FETCH_ASSOC);
            $this->mapear($dataSet);
            if (!empty($this->listado[0])) {
                return $this->listado[0];
            }
            return null;
        }catch (\PDOException $e){
            echo "ERROR_BD_TREARPORUSUARIO: {$e->getMessage()}";
            die();
        }
    }
    public function traerPorMail($email)
    {
        /** @noinspection SqlResolve */
        $sql = "CALL getcliente($email)";

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
        if($dataSet[0]) {
            $this->listado = array_map(function ($p) {
                $usuario = UsuarioBdDao::getInstance()->traerPorId($p['id_usuario']);
                $cliente = new Cliente(
                    $p['nombre'],
                    $p['apellido'],
                    $p['dni'],
                    $usuario->getEmail(),
                    $usuario->getPassword()
                );
                $cliente->setIdUsuario($p['id_usuario']);
                $cliente->setId($p['id_cliente']);
                return $cliente;
            }, $dataSet);
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
        // TODO: Implement retrieve() method.
    }
}
