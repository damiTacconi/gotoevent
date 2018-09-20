<?php
namespace Controladora;

use Dao\ClienteBdDao;
use Dao\UsuarioBdDao;
use Modelo\Cliente;
use Modelo\Usuario;
use Modelo\Pagina;
class CuentaControladora extends PaginaControladora {

    private $clienteBdDao;
    private $usuarioBdDao;

    function __construct()
    {
        $this->usuarioBdDao = UsuarioBdDao::getInstance();
        $this->clienteBdDao = ClienteBdDao::getInstance();
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
            if ($this->usuarioBdDao->verificarUsuario($email, $password)) {
                $cliente = $this->clienteBdDao->traerPorUsuario($email, $password);
                if ($cliente != null) {
                    $_SESSION['email'] = $cliente->getEmail();
                    $_SESSION['name'] = $cliente->getNombre() . ' ' . $cliente->getApellido();
                    $_SESSION['first_name'] = $cliente->getNombre();
                    $_SESSION['rol'] = 'cliente';
                } else {
                    $usuario = $this->usuarioBdDao->traerPorMail($email);
                    $_SESSION['email'] = $usuario->getEmail();
                    $_SESSION['name'] = $usuario->getEmail();
                    $_SESSION['first_name'] = $usuario->getEmail();
                    if(in_array($_SESSION['email'], unserialize(ADMIN_EMAIL))) {
                        $_SESSION['rol'] = 'admin';
                    }else $_SESSION['rol'] = 'cliente';
                }
                $_SESSION['picture_url'] = "";
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
            if (!$this->clienteBdDao->verificarDni($dni)) {
                if (!$this->usuarioBdDao->verificarEmail($email)) {
                    $cliente = new Cliente($nombre, $apellido, $dni, $email, $pass);
                    $id_usuario = $this->usuarioBdDao->agregar($cliente);
                    $cliente->setIdUsuario($id_usuario);
                    $id_cliente = $this->clienteBdDao->agregar($cliente);
                    $cliente->setId($id_cliente);
                    echo 'success';
                } else echo "EL EMAIL INGRESADO YA SE ENCUENTRA REGISTRADO";
            } else echo "EL DNI INGRESADO YA SE ENCUENTRA REGISTRADO";
        }else header('location: /');
    }

    function verificarSesion(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //sendMail();
            if (!empty($_SESSION)) {
                echo 'success';
            } else echo null;
        }else header('location: /');
    }
}
