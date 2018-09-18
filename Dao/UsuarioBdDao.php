<?php

namespace Dao;

use Modelo\Cliente;
use Modelo\Usuario;

class UsuarioBdDao
{
    protected $tabla = "usuarios";
    protected $listado;
    private static $instancia;

    public static function getInstancia()
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self();
        }
        return self::$instancia;
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
    public function agregar(Cliente $usuario)
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

    public function eliminarPorId($id)
    {
        /** @noinspection SqlResolve */
        $sql = "DELETE FROM $this->tabla WHERE idUsuario = \"$id\"";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();
    }

    public function eliminarPorMail($mail)
    {
        /** @noinspection SqlResolve */
        $sql = "DELETE FROM $this->tabla WHERE correo = \"$mail\"";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $sentencia->execute();
    }

    public function actualizar(Usuario $usuario)
    {
        /** @noinspection SqlResolve */
        $sql = "UPDATE $this->tabla SET correo = :mail, pwd = :pwd, idRol = :idRoles WHERE idUsuario = :idUsuarios";

        $conexion = Conexion::conectar();

        $sentencia = $conexion->prepare($sql);

        $mail = $usuario->getEmail();
        $idUsuarios = $usuario->getId();
        $pwd = $usuario->getPassword();

        $r = $usuario->getRol();
        $idRoles = $r->getId();

        $sentencia->bindParam(":mail", $mail);
        $sentencia->bindParam(":pwd", $pwd);
        $sentencia->bindParam(":idRoles", $idRoles);
        $sentencia->bindParam(":idUsuarios", $idUsuarios);

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
        /** @noinspection SqlResolve */
        $sql = "SELECT * FROM $this->tabla WHERE id_usuario =  \"$id\" LIMIT 1";

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

    public function traerPorMail($mail)
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
