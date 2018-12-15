<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 20:16
 */

namespace Dao;


use Modelo\Cliente;

class ClienteListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaClientes'])){
            $_SESSION['ListaClientes'] = array();
        }
    }

    private function setSessionCliente($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaClientes'] = $array;
    }
    private function getSessionCliente(){
        return $_SESSION['ListaClientes'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaClientes'])) {
            $ultimo = end($_SESSION['ListaClientes']);
            $index = array_search($ultimo, $_SESSION['ListaClientes']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaClientes'])){
            $this->mapear($_SESSION['ListaClientes']);
        }
        if(!empty($this->lista))
            return $this->lista;
        return null;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaClientes'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        if($lista) {
            foreach ($lista as $key => $item) {
                if ($item->getId() == $data->getId()) {
                    $eventoImagen = $data;
                    $lista[$key] = $eventoImagen;
                    break;
                }
            }
        }
        $this->setSessionCliente($lista);
    }

    public function delete($data)
    {
        $lista = $this->getAll();
        if($lista) {
            foreach ($lista as $key => $item) {
                if ($item->getId() == $data->getId()) {
                    unset($lista[$key]);
                    break;
                }
            }
        }
        $this->setSessionCliente($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionCliente();
        $array = [];
        if($lista) {
            foreach ($lista as $key => $item) {
                if ($item['id_cliente'] == $id) {
                    $array[] = $lista[$key];
                    break;
                }
            }
        }
        $this->mapear($array);
        if(!empty($this->lista)){
            return $this->lista[0];
        }
        return false;
    }

    public function verificarDni($dni){
        $clientes= $this->getAll();
        $flag = FALSE;
        if($clientes) {
            foreach ($clientes as $key => $item) {
                if ($item->getDni() === $dni) {
                    $flag = TRUE;
                    break;
                }
            }
        }
        return $flag;
    }

    public function eliminarPorDni($dni){
        $lista = $this->getAll();
        if($lista) {
            foreach ($lista as $key => $item) {
                if ($item->getDni() === $dni) {
                    unset($lista[$key]);
                    break;
                }
            }
        }
        $this->setSessionCliente($lista);
    }

    public function eliminarPorId($id){
        $lista = $this->getAll();
        if($lista) {
            foreach ($lista as $key => $item) {
                if ($item->getDni() == $id) {
                    unset($lista[$key]);
                    break;
                }
            }
        }
        $this->setSessionCliente($lista);
    }

    public function traerPorIdUsuario($id){
        $lista = $this->getAll();
        $cliente = null;
        if($lista) {
            foreach ($lista as $key => $item) {
                $usuario = $item->getUsuario();
                if ($usuario->getId() == $id) {
                    $cliente = $item;
                    break;
                }
            }
        }
        return $cliente;
    }
    public function traerPorEmail($email){
        $lista = $this->getAll();
        $cliente = null;
        if($lista) {
            foreach ($lista as $key => $item) {
                $usuario = $item->getUsuario();
                if ($usuario->getEmail() === $email) {
                    $cliente = $item;
                    break;
                }
            }
        }
        return $cliente;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $usuarioDao = UsuarioListaDao::getInstance();
            $usuario = $usuarioDao->retrieve($p['usuario']['id_usuario']);
            $cliente = new Cliente($p['nombre'],$p['apellido']);
            $cliente->setDni($p['dni']);
            $cliente->setUsuario($usuario);
            $cliente->setId($p['id_cliente']);
            return $cliente;
        }, $array);
    }
}