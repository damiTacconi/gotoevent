<?php
namespace Controladora;
# LISTAS
/*
use Dao\ClienteListaDao as ClienteDao;
use Dao\CompraListaDao as CompraDao;
use Dao\LineaListaDao as LineaDao;
use Dao\TicketListaDao as TicketDao;
use Dao\UsuarioListaDao as UsuarioDao;
*/
# BASE DE DATOS
use Dao\ClienteBdDao as ClienteDao;
use Dao\CompraBdDao as CompraDao;
use Dao\LineaBdDao as LineaDao;
use Dao\TicketBdDao as TicketDao;
use Dao\UsuarioBdDao as UsuarioDao;

use Modelo\Cliente;
use Modelo\Mensaje;
use Modelo\Usuario;
use Modelo\Pagina;
class CuentaControladora extends PaginaControladora {

    private $clienteDao;
    private $usuarioDao;
    private $ticketDao;
    private $compraDao;
    private $lineaDao;

    function __construct()
    {
        $this->lineaDao = LineaDao::getInstance();
        $this->compraDao = CompraDao::getInstance();
        $this->ticketDao = TicketDao::getInstance();
        $this->usuarioDao = UsuarioDao::getInstance();
        $this->clienteDao = ClienteDao::getInstance();
    }

    function index(){
        header('location: /');
    }
    function logout(){
        if(!empty($_SESSION)){

            unset($_SESSION['rol']);
            unset($_SESSION['email']);
            unset($_SESSION['name']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['picture_url']);
        }
        header('location: /');
    }
    function loguear($email , $password){
        try {
            if ($this->usuarioDao->verificarUsuario($email, $password)) {
                $usuario = $this->usuarioDao->traerPorEmail($email);
                if (in_array($usuario->getEmail(), unserialize(ADMIN_EMAIL))) {
                    $_SESSION['rol'] = 'admin';
                    $_SESSION['first_name'] = "";
                    $_SESSION['last_name'] = "";
                    $_SESSION['name'] = '';
                    $_SESSION['picture_url'] = "";
                    $_SESSION['email'] = $usuario->getEmail();
                    header('location: /');
                }else {
                    $cliente = $this->clienteDao->traerPorIdUsuario($usuario->getId());
                    if($cliente) {
                        $_SESSION['email'] = $usuario->getEmail();
                        $_SESSION['name'] = $cliente->getNombre() . ' ' . $cliente->getApellido();
                        $_SESSION['first_name'] = $cliente->getNombre();
                        $_SESSION['last_name'] = $cliente->getApellido();
                        $_SESSION['picture_url'] = "";
                        $_SESSION['rol'] = 'cliente';
                        $_SESSION['cart'] = array();
                        $_SESSION['cartPromo'] = array();
                        header('location: /');
                    }else {
                        $mensaje = new Mensaje("Hubo un error al procesar los datos de usuario", "danger");
                        $params['mensaje'] = $mensaje->getAlert();
                        $this->page("inicio", "GoToEvent", 0, $params);
                    }
                }
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

    function tickets(){
        $clienteDao = $this->clienteDao;
        $compraDao = $this->compraDao;
        $lineaDao = $this->lineaDao;
        $ticketDao = $this->ticketDao;

        if(isset($_SESSION['email'])){
            $cliente = $clienteDao->traerPorEmail($_SESSION['email']);
            $id_cliente = $cliente->getId();
            $compras = $compraDao->traerPorIdCliente($id_cliente);
            if($compras) {
                foreach ($compras as $compra) {
                    $id_compra = $compra->getId();
                    $lineas = $lineaDao->traerPorIdCompra($id_compra);
                    foreach ($lineas as $linea) {
                        $id_linea = $linea->getId();
                        $tickets = $ticketDao->traerPorIdLinea($id_linea);
                        $linea->setTickets($tickets);

                    }
                    $compra->setLineas($lineas);
                }

                $cliente->setCompras($compras);
            }
            $params['cliente'] = $cliente;
            $this->page("tickets","Tickets",1,$params);

        }else header("location: /");

    }

    function usuarios(){
        $this->listado();
    }
    private function listado($params = []){
        $clienteDao = $this->clienteDao;
        $clientes = $clienteDao->getAll();
        $params['clientes'] = $clientes;
        $this->page("listado/listadoUsuarios" , "Usuarios" , 2 , $params);
    }
    function eliminarUsuario($id){
        $usuarioDao =  $this->usuarioDao;
        $usuario = $usuarioDao->retrieve($id);

        if($usuario):
            $usuarioDao->delete($usuario);
            $mensaje = new Mensaje("EL USUARIO SE ELIMINO CORRECTAMENTE" , "success");
            $params['mensaje'] = $mensaje->getAlert();
        else:
            $mensaje = new Mensaje("NO SE ENCONTRO EL USUARIO" , "danger");
            $params['mensaje'] = $mensaje->getAlert();
        endif;
        $this->listado($params);

    }
}
