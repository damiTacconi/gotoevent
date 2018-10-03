<?php
namespace Controladora;

use Dao\ClienteBdDao;
use Dao\UsuarioBdDao;
use Modelo\Cliente;
use Modelo\Mensaje;
use Modelo\Usuario;
use Modelo\Pagina;
class CuentaControladora extends PaginaControladora {

    private $clienteDao;
    private $usuarioDao;

    function __construct()
    {
        $this->usuarioDao = UsuarioBdDao::getInstance();
        $this->clienteDao = ClienteBdDao::getInstance();
    }

    function index(){
        header('location: /');
    }
    function logout(){
        if(!empty($_SESSION)){
            if (ini_get("session.use_cookies") == true) {
                $parametros = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 99999,
                    $parametros["path"],
                    $parametros["domain"],
                    $parametros["secure"],
                    $parametros["httponly"]
                );
            }
            session_destroy();
        }
        header('location: /');
    }
    function loguear($email , $password){
        try {
            if ($this->usuarioDao->verificarUsuario($email, $password)) {
                $usuario = $this->usuarioDao->traerPorEmail($email);
                $_SESSION['email'] = $usuario->getEmail();
                $cliente = $this->clienteDao->traerPorIdUsuario($usuario->getId());
                $_SESSION['name'] = $cliente->getNombre() . ' ' . $cliente->getApellido();
                $_SESSION['first_name'] = $cliente->getNombre();
                $_SESSION['last_name'] = $cliente->getApellido();
                $_SESSION['picture_url'] = "";
                if(in_array($_SESSION['email'], unserialize(ADMIN_EMAIL))) {
                    $_SESSION['rol'] = 'admin';
                }else $_SESSION['rol'] = 'cliente';
                header('location: /');
            }else {
                $mensaje = ("<span style='color:black;'>Email o contraseña incorrecto.</span>");
                $params = ['mensaje' => $mensaje];
                $this->page('inicio', 'GoToEvent',0,$params);
            }
        }catch (\Exception $e){
            echo 'Ocurrio un error: ' . $e->getMessage();
            echo "<a href='/'> Volver </a>";
            die();
        }
	 }

    function perfil(){
  	    $this->page('perfil' , $_SESSION['name'] , 1);
    }

    function registrarAjax($nombre,$apellido,$dni,$email,$pass){
        if(!empty($_POST)) {
            if (!$this->clienteDao->verificarDni($dni)) {
                if (!$this->usuarioDao->verificarEmail($email)) {
                    $usuario = new Usuario($email,$pass);
                    $id_usuario = $this->usuarioDao->save($usuario);
                    $usuario->setId($id_usuario);
                    $cliente = new Cliente($nombre, $apellido);
                    $cliente->setDni($dni);
                    $cliente->setUsuario($usuario);
                    $this->clienteDao->save($cliente);
                    echo 'success';
                } else echo "EL EMAIL INGRESADO YA SE ENCUENTRA REGISTRADO";
            } else echo "EL DNI INGRESADO YA SE ENCUENTRA REGISTRADO";
        }else header('location: /');
    }

    function verificarSesionCliente(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //sendMail();
            if ($_SESSION['rol'] === 'cliente') {
                echo 'success';
            } else echo null;
        }else header('location: /');
    }
}
