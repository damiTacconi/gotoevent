<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 18:38
 */

namespace Dao;


use Modelo\Usuario;

class UsuarioListaDao extends SingletonDao implements IDao
{

    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaUsuarios'])){
            $_SESSION['ListaUsuarios'] = array(
                0 => [
                    "id_usuario" => 0,
                    "email" => 'admin@admin.com',
                    "password" => 'admin'
                ]
            );
        }
    }

    private function setSessionUsuario($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaUsuarios'] = $array;
    }
    private function getSessionUsuario(){
        return $_SESSION['ListaUsuarios'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaUsuarios'])) {
            $ultimo = end($_SESSION['ListaUsuarios']);
            $index = array_search($ultimo, $_SESSION['ListaUsuarios']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaUsuarios'])){
            $this->mapear($_SESSION['ListaUsuarios']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaUsuarios'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $eventoImagen = $data;
                $lista[$key] = $eventoImagen;
                break;
            }
        }
        $this->setSessionUsuario($lista);
    }

    public function delete($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                unset($lista[$key]);
                break;
            }
        }
        $this->setSessionUsuario($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionUsuario();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_usuario'] == $id){
                $array[] = $lista[$key];
                break;
            }
        }
        $this->mapear($array);
        if(!empty($this->lista)){
            return $this->lista[0];
        }
        return false;
    }

    public function verificarUsuario($email,$password){
        $usuarios = $this->getAll();
        $flag = FALSE;
        foreach ($usuarios as $key => $item){
            if($item->getEmail() === $email && $item->getPassword() === $password){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    public function verificarEmail($email){
        $usuarios = $this->getAll();
        $flag = FALSE;
        foreach ($usuarios as $key => $item){
            if($item->getEmail() === $email ){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    public function traerPorEmail($email){
        $usuarios = $this->getAll();
        $usuario = false;
        foreach ($usuarios as $key => $item){
            if($item->getEmail() === $email ){
                $usuario = $item;
                break;
            }
        }
        return $usuario;
    }


    private function mapear($array){
        $this->lista = array_map( function($p){
            $usuario = new Usuario($p['email'] , $p['password']);
            $usuario->setId($p['id_usuario']);
            return $usuario;
        }, $array);
    }
}