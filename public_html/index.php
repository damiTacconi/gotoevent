<?php
// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
date_default_timezone_set('America/Argentina/Buenos_Aires');

//setlocale(LC_TIME, 'es_ES.UTF-8');         // ---UNIX
setlocale(LC_TIME, 'spanish'); // ---Windows

//si la session esta vacia, la inicio
if(empty($_SESSION)){
    session_start();
    if(!isset($_SESSION['rol'])){
        $_SESSION['rol'] = 'invitado';
    }
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    if(!isset($_SESSION['cartPromo'])){
        $_SESSION['cartPromo'] = array();
    }
}

require_once("../Config/Config.php");
require_once("../Config/Autoload.php");

use \Config\Autoload as Autoload;
use Config\Router;
use Config\Request;

Autoload::autoload();
Router::direccionar(new Request());

